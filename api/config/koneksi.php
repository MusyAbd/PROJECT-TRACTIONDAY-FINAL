<?php
// Koneksi PostgreSQL langsung ke Supabase
// Pastikan ekstensi pgsql aktif di PHP

$host = "aws-1-ap-southeast-1.pooler.supabase.com";
$port = "6543";
$dbname = "postgres";
$db_user = "postgres.etvmpmlvktzikoqpjzpe"; // ganti sesuai user DB jika berbeda
$db_pass = "@Tractionday2026"; // ganti sesuai password DB

// Koneksi via parameter key/value (lebih aman bila password mengandung '@')
$connection_string = "host=$host port=$port dbname=$dbname user=$db_user password=$db_pass sslmode=require";

$koneksi = @pg_connect($connection_string);
if (!$koneksi) {
    $last = error_get_last();
    $err = ($last && isset($last['message'])) ? $last['message'] : 'Tidak dapat membuka koneksi PostgreSQL';
    die("Koneksi gagal: " . $err);
}

// Gunakan encoding UTF-8 untuk data Supabase
pg_set_client_encoding($koneksi, 'UTF8');
?>
