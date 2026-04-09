<?php
session_start();
if ($_SESSION['role'] != "kasir") {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="kasir.css?v=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                🏠
                <div>
                    Dashboard Kasir
                    <span>Sistem Manajemen Apotek</span>
                </div>
            </div>
            <a href="logout.php" class="btn-outline">Keluar</a>
        </div>

        <div class="content">
            <div class="alert-success">
                ✔️ Login Berhasil! Selamat datang, Anda login sebagai Kasir.
            </div>

            <div class="card">
                <div class="card-title">Menu Utama</div>
                <a href="transaksi.php" class="menu-item">
                    <div class="icon">🛒</div>
                    <div>
                        <b>Transaksi Penjualan</b>
                        <p>Proses penjualan obat</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <div class="card-title">Informasi Sistem</div>
                <table class="sys-info">
                    <tr>
                        <th>Parameter</th>
                        <th style="text-align: right;">Nilai</th>
                    </tr>
                    <tr>
                        <td>Role Pengguna</td>
                        <td><span class="badge">Kasir</span></td>
                    </tr>
                    <tr>
                        <td>Status Login</td>
                        <td><span style="color: #10b981; font-size: 18px;">●</span> Aktif</td>
                    </tr>
                    <tr>
                        <td>Waktu Login</td>
                        <td><?= date("H:i:s"); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>