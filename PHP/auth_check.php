<?php
// FILE: auth_check.php (SUDAH DIPERBAIKI)
// File ini untuk memastikan hanya pengguna yang sudah login yang bisa mengakses halaman.
// Letakkan di bagian paling atas setiap halaman yang terproteksi.

session_start(); // WAJIB: Memulai atau melanjutkan session

// Jika session 'loggedin' tidak ada atau tidak bernilai true,
// maka alihkan pengguna ke halaman login.
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>