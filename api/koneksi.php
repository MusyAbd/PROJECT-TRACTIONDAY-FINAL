<?php
// Cek apakah file env_lokal.php ada (artinya ini lagi jalan di XAMPP)
if (file_exists(__DIR__ . '/env_lokal.php')) {
    require_once __DIR__ . '/env_lokal.php';
}

// Ambil kredensial (di Vercel ambil dari setting dashboard, di XAMPP ambil dari file env_lokal.php)
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');

$connection_string = "host=$host port=$port dbname=$dbname user=$db_user password=$db_pass sslmode=require";

$koneksi = @pg_connect($connection_string);

if (!$koneksi) {
    $last = error_get_last();
    $err = ($last && isset($last['message'])) ? $last['message'] : 'Tidak dapat membuka koneksi PostgreSQL';
    die("Koneksi gagal: " . $err);
}

pg_set_client_encoding($koneksi, 'UTF8');
?>
