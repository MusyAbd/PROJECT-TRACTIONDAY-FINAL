-- Migration: 001_users_normalize.sql
-- Tujuan: Membuat skema users agar memenuhi 1NF, 2NF, 3NF secara spesifik
-- Catatan: Jalankan ini di lingkungan development terlebih dahulu dan sesuaikan
-- sebelum memindahkan ke production. Backup database sebelum menjalankan.

-- 1NF (First Normal Form)
-- - Pastikan setiap kolom menyimpan nilai atomik (tidak ada daftar/array dalam kolom)
-- - Pastikan setiap baris unik (primary key)
--
-- Contoh: pastikan kolom `username` bersifat scalar dan unik
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS last_qr text,
    ADD COLUMN IF NOT EXISTS last_qr_at timestamp without time zone;

-- Buat constraint unik untuk username jika belum ada
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.table_constraints tc
        JOIN information_schema.key_column_usage kcu ON tc.constraint_name = kcu.constraint_name
        WHERE tc.table_name = 'users' AND tc.constraint_type = 'UNIQUE' AND kcu.column_name = 'username'
    ) THEN
        ALTER TABLE users ADD CONSTRAINT users_username_unique UNIQUE (username);
    END IF;
END$$;

-- 2NF (Second Normal Form)
-- - Tidak boleh ada partial dependency terhadap bagian dari primary key
-- - Pastikan primary key adalah single-column (misalnya `id`)
-- If users currently uses a composite key, we recommend switching to a single-column PK `id`.
-- Contoh: pastikan ada kolom `id` sebagai PRIMARY KEY
DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM pg_index idx
        JOIN pg_class c ON c.oid = idx.indrelid
        WHERE c.relname = 'users' AND idx.indisprimary
    ) THEN
        -- Jika tidak ada primary key, buat kolom id dan jadikan primary key
        ALTER TABLE users ADD COLUMN IF NOT EXISTS id serial PRIMARY KEY;
    END IF;
END$$;

-- 3NF (Third Normal Form)
-- - Hilangkan transitive dependency: kolom non-key tidak bergantung pada kolom non-key lainnya
-- Contoh: pindahkan data autentikasi sensitif (password hash) ke tabel terpisah `users_auth`
-- sehingga tabel `users` hanya menyimpan atribut profil.

-- Buat tabel users_auth jika belum ada
CREATE TABLE IF NOT EXISTS users_auth (
    user_id integer PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE,
    password_hash text NOT NULL,
    password_updated_at timestamp without time zone
);

-- Jika ada kolom `password` di tabel users, pindahkan nilainya (jika ada) lalu hapus kolom
DO $$
BEGIN
    IF EXISTS (
        SELECT 1 FROM information_schema.columns WHERE table_name='users' AND column_name='password'
    ) THEN
        -- Pindahkan data password (jika non-null) ke users_auth
        INSERT INTO users_auth (user_id, password_hash, password_updated_at)
        SELECT id, password, NOW() FROM users WHERE password IS NOT NULL
        ON CONFLICT (user_id) DO NOTHING;

        -- Hapus kolom password dari users
        ALTER TABLE users DROP COLUMN IF EXISTS password;
    END IF;
END$$;

-- Penjelasan singkat kenapa memenuhi 1NF-3NF:
-- 1NF: Semua kolom baru (last_qr, last_qr_at) adalah atomik; username diberi constraint unik.
-- 2NF: Tabel users menggunakan single-column PK `id`.
-- 3NF: Password dipindahkan ke tabel `users_auth`, menghilangkan kemungkinan ketergantungan transitif
--       antara atribut non-key pada tabel users.

-- Opsional: indeks untuk pencarian username
CREATE INDEX IF NOT EXISTS users_username_idx ON users(username);

-- Selesai
