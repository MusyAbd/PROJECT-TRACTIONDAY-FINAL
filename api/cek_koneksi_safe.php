<?php
// FILE: cek_koneksi_safe.php
// Deskripsi: Skrip pengecekan koneksi PostgreSQL yang aman.
// - Memanggil file koneksi yang sama (config/koneksi.php)
// - Menggunakan pemeriksaan `function_exists` sebelum memanggil fungsi pg_*
// - Menyediakan fallback parsing connection string bila fungsi helper tidak tersedia
// - Menangani dan menampilkan error dengan cara aman

// Petunjuk penggunaan:
// 1. Tempatkan file ini di folder PHP/ (sudah benar).
// 2. Pastikan file koneksi Anda (`config/koneksi.php`) menyetel variabel $koneksi
//    hasil dari pg_connect(...) atau null/false jika gagal.
// 3. Akses dari browser: http://localhost/PROJECT-TRACTIONDAY/PHP/cek_koneksi_safe.php

// Jangan keluarkan informasi sensitif (password) ke halaman publik di produksi.

// Muat file koneksi (harus mengatur $koneksi)
require_once __DIR__ . '/config/koneksi.php';

header('Content-Type: text/html; charset=utf-8');

echo '<h1>Informasi Koneksi Database (safe)</h1>';

// Pastikan variabel $koneksi tersedia
if (!isset($koneksi) || !$koneksi) {
    echo "<p style='color:red; font-weight:bold;'>Koneksi belum dibuat atau gagal.</p>";
    // Tampilkan pesan terakhir jika tersedia
    if (function_exists('pg_last_error')) {
        echo '<p>Error detail: ' . htmlspecialchars(pg_last_error()) . '</p>';
    } else {
        $err = error_get_last();
        echo '<p>Error detail: ' . htmlspecialchars($err['message'] ?? 'Tidak ada detail error') . '</p>';
    }
    exit;
}

// Ambil informasi host:port dengan aman
$host_info = 'Tidak tersedia';
if (function_exists('pg_host') && function_exists('pg_port')) {
    $h = pg_host($koneksi);
    $p = pg_port($koneksi);
    $host_info = ($h ?: 'unknown') . ':' . ($p ?: 'unknown');
} else {
    // Coba parsing connection string bila fungsi tidak ada
    if (function_exists('pg_connection_string')) {
        $conn = pg_connection_string($koneksi);
    } elseif (defined('PGSQL_CONNECTION') && PGSQL_CONNECTION) {
        $conn = (string)PGSQL_CONNECTION;
    } else {
        // Jika tidak tersedia, ambil dari konfigurasi koneksi di file koneksi.php
        $conn = $GLOBALS['__PG_CONN_STRING'] ?? null;
    }
    if (!empty($conn) && preg_match('/host=([^\s]+)|port=([^\s]+)/', $conn)) {
        $h = 'unknown'; $p = 'unknown';
        if (preg_match('/host=([^\s]+)/', $conn, $m)) $h = $m[1];
        if (preg_match('/port=([^\s]+)/', $conn, $m)) $p = $m[1];
        $host_info = $h . ':' . $p;
    }
}

// Ambil versi server jika tersedia
$server_info = 'Tidak diketahui';
if (function_exists('pg_version')) {
    $ver = pg_version($koneksi);
    if (is_array($ver) && isset($ver['server'])) $server_info = $ver['server'];
}

// Query data_directory jika fungsi query ada
$data_dir = 'Tidak tersedia';
if (function_exists('pg_query')) {
    $res = @pg_query($koneksi, "SELECT current_setting('data_directory') AS data_dir");
    if ($res) {
        $row = pg_fetch_assoc($res);
        if ($row && isset($row['data_dir'])) $data_dir = $row['data_dir'];
        if (function_exists('pg_free_result')) pg_free_result($res);
    }
}

echo '<ul>';
echo '<li><b>Info Host:</b> ' . htmlspecialchars($host_info) . '</li>';
echo '<li><b>Versi Server:</b> ' . htmlspecialchars($server_info) . '</li>';
echo '<li><b>Lokasi Folder Data:</b> ' . htmlspecialchars($data_dir) . '</li>';
echo '</ul>';

// Tutup koneksi kalau fungsi tersedia
if (function_exists('pg_close')) pg_close($koneksi);

// Penutup: rekomendasi tindakan bila diperlukan
echo '<hr>';
echo '<p>Rekomendasi:</p>';
echo '<ol>';
echo '<li>Pastikan ekstensi PostgreSQL aktif di <code>php.ini</code> (extension=pgsql, extension=pdo_pgsql) dan restart Apache/XAMPP.</li>';
echo '<li>Jika VS Code menandai "call to unknown function", konfigurasi php.validate.executablePath ke <code>C:\\xampp\\php\\php.exe</code> atau pasang stubs/intelephense.</li>';
echo '<li>Jangan tampilkan password/DSN lengkap di halaman publik.</li>';
echo '</ol>';

?>