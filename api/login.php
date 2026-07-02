<head>
    <link rel="stylesheet" href="/CSS/WIP.css">
</head>
<body>
    <div class="parent-container">
        <div class="login-container">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/04/Telkomsel_%282021%29.svg/500px-Telkomsel_%282021%29.svg.png" style="margin: 24px;" class="gambar-logo" alt="Logo Petrokimia Gresik">
            <form action="login_process.php" method="POST" class="login-form"> 
                <input class="fillbar" style="margin-top: 8px;" type="text" name="username" placeholder="Username" required>
                <input class="fillbar" style="margin-top: 8px;" type="password" name="password" placeholder="Password" required >
                <button type="btn-generate" class="btn-generate" style="margin-top: 24px;">Generate QR</button>
            </form>
            <?php
            // Tampilkan pesan sukses atau error jika ada
            if (isset($_SESSION['success'])) {
                echo '<p class="login-success">' . htmlspecialchars($_SESSION['success']) . '</p>';
                unset($_SESSION['success']);
            }
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<script>alert("Login gagal. Periksa username dan password Anda.");</script>';
            }
            ?>
        </div>
    </div>
</body>
</html>