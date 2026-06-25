<?php
// Cek apakah cookie loggedin belum ada atau nilainya bukan true
if (!isset($_COOKIE["loggedin"]) || $_COOKIE["loggedin"] !== "true") {
    // Jika belum login, tendang ke halaman login
    header("Location: /login.php");
    exit();
}
?>