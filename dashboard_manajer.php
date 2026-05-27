<?php
session_start();
if ($_SESSION['role'] != "manajer") {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Manajer</title>
    <link rel="stylesheet" href="manajer.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                🏠
                <div>
                    Dashboard Manajer
                    <span>Sistem Manajemen Apotek</span>
                </div>
            </div>
            <a href="logout.php" class="btn-outline">Keluar</a>
        </div>

        <div class="content">
            <div class="alert-success">
                ✔️ Login Berhasil! Selamat datang, Anda login sebagai Manajer.
            </div>

            <div class="card">
                <div class="card-title">Menu Utama</div>
                <a href="laporan_analisis.php" class="menu-item">
                    <div class="icon">📊</div>
                    <div><b>Laporan & Analisis</b>
                        <p>Lihat laporan penjualan</p>
                    </div>
                </a>
            </div>

            <div class="card">
                <div class="card-title">Daftar Pengguna Baru</div>
                <a href="kelola_pengguna.php" class="menu-item" style="margin-bottom:0;">
                    <div class="icon">👥</div>
                    <div><b>Daftar</b>
                        <p>Daftar Pengguna</p>
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
                        <td><span class="badge">Manajer</span></td>
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