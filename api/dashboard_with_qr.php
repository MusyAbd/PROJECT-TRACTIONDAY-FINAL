<?php
require_once __DIR__ . '/auth_check.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./CSS/dashboard.css">
    <script type="text/javascript" src="./JS-UI/dashboard.js" defer></script>
</head>
<body class="dashboard-body">
    <div class="parent">
        <div class="sidebar" id="sidebar">
            <!-- Sidebar content -->
            <button class="hamburger" id="hamburger-btn">☰</button>
            <div class="sidebarmenu" id="sidebarmenu">
                <div style="color: white; margin-top: 0; padding: 4px 18px;">
                <a class="minimenu" href="./dashboard_with_qr.php">Home</a>
                <a class="minimenu" href="./qr_secure.php">Scan QR</a>
                <a class="minimenu" href="./settings.php">Pengaturan</a>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="card">
                <h1>Dashboard</h1>
                <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Pengguna'); ?>.</p>
                <p>Anda sudah login dan bisa mengakses halaman ini.</p>
                <div style="display:flex; gap:12px; justify-content:center; margin-top:18px;">
            <a class="btn" href="./qr_secure.php">Buka QR</a>
            <a class="btn" href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
