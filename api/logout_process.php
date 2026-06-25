<?php
// BAGIAN: LOGOUT_PROCESS.PHP
// Backend untuk menghancurkan session dan logout.

session_start();

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Alihkan kembali ke halaman login
header('Location: login.php');
exit;
?>