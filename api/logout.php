<?php
/*session_start();

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
cookie_destroy();

// Alihkan kembali ke login
header('Location: dashboard_with_qr.php');
exit;
*/
// "Bunuh" semua cookie dengan mengatur waktunya mundur 1 jam (time() - 3600)
// Pastikan nama-nama cookie ini sesuai dengan yang kamu buat saat login
setcookie("loggedin", "", time() - 3600, "/");
setcookie("id", "", time() - 3600, "/");
setcookie("username", "", time() - 3600, "/");
setcookie("last_qr", "", time() - 3600, "/");

// Alihkan kembali ke halaman login (Gunakan garis miring awal untuk Vercel)
header('Location: /api/dashboard_with_qr_copy.php');
exit();
?>