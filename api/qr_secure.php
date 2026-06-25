<?php
/**
 * qr_secure.php
 *
 * Versi siap-deploy untuk menggantikan `qr.php`.
 * - Mengambil username terbaru dari database menggunakan session id.
 * - Menggabungkan dengan kata acak yang dihasilkan server.
 * - Menghasilkan QR image di sisi klien menggunakan `qrgenerator.js`.
 *
 * NOTE: Ini siap dipakai, tetapi jika Anda butuh QR generator lokal (tanpa
 * bergantung ke API eksternal), beri tahu saya supaya saya tambahkan library
 * PHP QR generator ke project.
 */

require_once __DIR__ . '/config/koneksi.php';

$qrData = null;
$username = $_COOKIE['username'] ?? null;
$userId = $_COOKIE['id'] ?? null;

if ($userId) {
    $sql = 'SELECT username, last_qr FROM users WHERE id = $1 LIMIT 1';
    $res = pg_query_params($koneksi, $sql, [$userId]);
    if ($res && pg_num_rows($res) === 1) {
        $row = pg_fetch_assoc($res);
        pg_free_result($res);
        $username = $row['username'] ?? $username;
        $qrData = $row['last_qr'] ?? null;
    }
}

if (!$username) {
    $username = 'user_unknown';
}

$saveMessage = null;
if (empty($qrData)) {
    $qrData = $username . '_' . substr(bin2hex(random_bytes(3)), 0, 6);
    if ($userId) {
        $upd = pg_query_params($koneksi, 'UPDATE users SET last_qr = $1 WHERE id = $2 AND (last_qr IS NULL OR last_qr = \'\')', [$qrData, $userId]);
        if ($upd) {
            if (pg_affected_rows($upd) > 0) {
                $saveMessage = 'Berhasil menyimpan QR ke database.';
            } else {
                $saveMessage = 'QR sudah ada di database.';
            }
            pg_free_result($upd);
        }
    }
} 

/*setcookie("last_qr", $qrData, time() + 86400, "/");*/
$combined = $qrData;
?>


    <div class= "card" style="max-width:420px;margin:0 auto;text-align:center;padding:18px;border:1px solid #ddd;border-radius:8px">
        <h2>QR Code <?php echo htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h2>
                <canvas id="qrcode-canvas" width="150%" height="150%" style="display:block; margin:12px auto;border:1px solid background-color:transparent"></canvas>

        <?php if ($saveMessage !== null): ?>
            <p style="margin-top:10px;color:#333;font-weight:600"><?php echo htmlspecialchars($saveMessage, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
        <?php endif; ?>

        <div style="display:flex;gap:8px;justify-content:center;margin-top:12px">
            <a class="btn" href="./dashboard_with_qr_copy.php">Kembali</a>
        </div>
    
        <script src="/qrgenerator.js"></script>
        <script>
            // Gunakan qrgenerator.js untuk membuat QR di canvas
            const combinedValue = <?php echo json_encode($combined, JSON_UNESCAPED_UNICODE); ?>;
            const canvas = document.getElementById('qrcode-canvas');
            try {
                const qr = qrcodegen.QrCode.encodeText(combinedValue, qrcodegen.QrCode.Ecc.MEDIUM);
                qr.drawCanvas(8, 6, canvas);//awalnya 5,4
            } catch (err) {
                console.error('QR generation failed', err);
                // fallback: tulis teks
                const ctx = canvas.getContext('2d');
                ctx.font = '14px sans-serif';
                ctx.fillText('QR generation failed', 10, 20);
            }

            function openImage() {
                const dataUrl = canvas.toDataURL('image/png');
                const w = window.open('about:blank');
                if (w) {
                    const img = w.document.createElement('img');
                    img.src = dataUrl;
                    img.alt = 'QR Code';
                    img.style.maxWidth = '100%';
                    w.document.body.style.margin = '0';
                    w.document.body.appendChild(img);
                } else {
                    alert('Pop-up diblokir. Izinkan pop-up untuk membuka gambar.');
                }
            }

            function downloadImage() {
                const dataUrl = canvas.toDataURL('image/png');
                const a = document.createElement('a');
                a.href = dataUrl;
                a.download = 'qr_<?php echo htmlspecialchars($username, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            }

            document.getElementById('open-btn').addEventListener('click', openImage);
            document.getElementById('download-btn').addEventListener('click', downloadImage);
        </script>
    </div>
</body>
</html>
