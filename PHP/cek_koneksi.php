<?php
// FILE: cek_koneksi.php

echo "<h1>Informasi Koneksi Database dari Aplikasi PHP</h1>";

// Memanggil file koneksi yang sama dengan yang digunakan oleh API Anda
require 'config/koneksi.php';

if ($koneksi) {
    echo "<p style='color:green; font-weight:bold;'>Koneksi Berhasil!</p>";

    // Mendapatkan informasi detail dari server yang terhubung
    $host_info = pg_host($koneksi) . ':' . pg_port($koneksi);
    $version_info = pg_version($koneksi);
    $server_info = $version_info['server'] ?? 'Tidak diketahui';

    // Mendapatkan lokasi folder data fisik dari server (jika boleh diakses)
    $data_dir = 'Tidak tersedia';
    $query = pg_query($koneksi, "SELECT current_setting('data_directory') AS data_dir");
    if ($query) {
        $row = pg_fetch_assoc($query);
        if ($row && isset($row['data_dir'])) {
            $data_dir = $row['data_dir'];
        }
        pg_free_result($query);
    }

    echo "<ul>";
    echo "<li><b>Info Host:</b> " . htmlspecialchars($host_info) . "</li>";
    echo "<li><b>Versi Server:</b> " . htmlspecialchars($server_info) . "</li>";
    echo "<li><b>Lokasi Folder Data:</b> " . htmlspecialchars($data_dir) . "</li>";
    echo "</ul>";

    pg_close($koneksi);

} else {
    echo "<p style='color:red; font-weight:bold;'>Koneksi Gagal!</p>";
    echo "<p>Error: " . pg_last_error() . "</p>";
}

echo "<hr><h2>Apa Selanjutnya?</h2>";
echo "<p>Sekarang, buka phpMyAdmin Anda dan bandingkan informasi di atas (terutama <b>Versi Server</b> dan <b>Lokasi Folder Data</b>) dengan informasi yang ditampilkan di halaman utama phpMyAdmin. Jika ada perbedaan, maka terbukti Anda memiliki dua server database yang berbeda.</p>";

?>