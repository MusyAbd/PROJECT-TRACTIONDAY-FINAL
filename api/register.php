<?php
session_start();
require 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($username === '' || $password === '' || $confirm_password === '') {
        $_SESSION['error'] = 'Semua field wajib diisi.';
        header('Location: register.php');
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Password dan konfirmasi password tidak sama.';
        header('Location: register.php');
        exit;
    }

    $query = 'SELECT 1 FROM users WHERE username = $1';
    $result = pg_query_params($koneksi, $query, [$username]);
    if ($result && pg_num_rows($result) > 0) {
        pg_free_result($result);
        $_SESSION['error'] = 'Username sudah terdaftar.';
        header('Location: register.php');
        exit;
    }

    if ($result) {
        pg_free_result($result);
        $_SESSION['success'] = 'Registrasi berhasil. Silakan login.';
        header('Location: login.php');
        exit;
    }

    $_SESSION['error'] = 'Terjadi kesalahan saat registrasi. Coba lagi nanti.';
    header('Location: register.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Petrokimia Gresik</title>
    <link rel="stylesheet" href="../CSS/Loginstyle.css">
</head>
<body class="login-bg">
    <div class="login-container">
        <div class="logo">
            <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="Logo Petrokimia Gresik">
        </div>
        <?php
        if (isset($_SESSION['error'])) {
            echo '<p class="login-alert">' . htmlspecialchars($_SESSION['error']) . '</p>';
            unset($_SESSION['error']);
        }
        ?>
        <form action="register.php" method="POST" class="login-form">
            <input class="fillbar" type="text" name="username" placeholder="Username" required>
            <input class="fillbar" type="password" name="password" placeholder="Password" required>
            <input class="fillbar" type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit" class="btn">Register</button>
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
        </form>
    </div>
</body>
</html>
