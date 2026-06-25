<?php
session_start();

// Hapus semua variabel session
$_COOKIE = array();

// Hancurkan session
cookie_destroy();

// Alihkan kembali ke login
header('Location: dashboard_with_qr.php');
exit;
