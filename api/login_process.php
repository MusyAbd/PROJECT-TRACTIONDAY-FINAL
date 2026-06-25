<?php
// FILE: login_process.php (VERSI FINAL & BERSIH)

session_start();
require 'config/koneksi.php';

// Cek apakah data username dan password dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input
    if ($username !== '' && $password !== '') {
        $sql = 'SELECT id, username, password, last_qr FROM users WHERE username = $1';
        $result = pg_query_params($koneksi, $sql, [$username]);

        if ($result && pg_num_rows($result) === 1) {
            $row = pg_fetch_assoc($result);
            if ($row && password_verify($password, $row['password'])) {
                // Password benar, mulai session baru
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $row['id'];
                $_SESSION["username"] = $row['username'];

                // Buat last_qr jika belum ada, format username_random
                $lastQr = $row['last_qr'] ?? null;
                if (empty($lastQr)) {
                    $lastQr = $row['username'] . '_' . substr(bin2hex(random_bytes(3)), 0, 6);
                    $updateSql = 'UPDATE users SET last_qr = $1 WHERE id = $2';
                    $updateRes = pg_query_params($koneksi, $updateSql, [$lastQr, $row['id']]);
                    if ($updateRes) {
                        pg_free_result($updateRes);
                    }
                }

                $_SESSION["last_qr"] = $lastQr;
                // Alihkan ke halaman dashboard setelah login
                header('Location: ./dashboard_with_qr_copy.php');
                exit();
            }
        }

        if ($result) {
            pg_free_result($result);
        }
    }

    // Jika login gagal (username atau password salah), alihkan kembali dengan pesan error
    header("Location: login.php?error=1");
    exit();

} else {
    // Jika halaman diakses langsung tanpa metode POST
    header("Location: login.php");
    exit();
}
?>
