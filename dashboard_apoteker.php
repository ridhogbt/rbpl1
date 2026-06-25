<?php
session_start();
include "koneksi.php"; // Pastikan koneksi database dipanggil
if ($_SESSION['role'] != "apoteker") {
    header("Location: login.php");
    exit;
}

// Cek Stok Minimum (Kurang dari 10)
$q_stok = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM obat WHERE stok < 10");
$d_stok = mysqli_fetch_assoc($q_stok);
$stok_menipis = $d_stok['jumlah'];

// Cek Obat Kadaluarsa (Dalam 30 hari ke depan)
$q_exp = mysqli_query($conn, "SELECT COUNT(*) as jumlah FROM obat WHERE expired <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)");
$d_exp = mysqli_fetch_assoc($q_exp);
$obat_exp = $d_exp['jumlah'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Apoteker</title>
    <link rel="stylesheet" href="apoteker.css?v=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                🏠
                <div>
                    Dashboard Apoteker
                    <span>Sistem Manajemen Apotek</span>
                </div>
            </div>
            <a href="logout.php" class="btn-outline">Keluar</a>
        </div>

        <div class="content">
            <div class="alert-success" style="margin-bottom: 10px;">
                ✔️ Login Berhasil! Selamat datang, <?= htmlspecialchars($_SESSION['user']) ?>.
            </div>

            <?php if ($stok_menipis > 0): ?>
                <div style="background:#fffbeb; color:#b45309; padding:12px; border-radius:8px; border:1px solid #fde68a; font-size:12px; margin-bottom:10px;">
                    ⚠️ <b>Peringatan Stok:</b> Terdapat <b><?= $stok_menipis ?> jenis obat</b> yang stoknya menipis (kurang dari 10).
                </div>
            <?php endif; ?>

            <?php if ($obat_exp > 0): ?>
                <div style="background:#fef2f2; color:#b91c1c; padding:12px; border-radius:8px; border:1px solid #fecaca; font-size:12px; margin-bottom:15px;">
                    ❗ <b>Peringatan Expired:</b> Terdapat <b><?= $obat_exp ?> jenis obat</b> yang sudah kadaluarsa atau akan kadaluarsa dalam 30 hari!
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-title">Menu Utama</div>
                <a href="inventaris.php" class="menu-item" style="margin-bottom:0;">
                    <div class="icon">📦</div>
                    <div>
                        <b>Manajemen Inventaris</b>
                        <p>Kelola data obat & Resep</p>
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
                        <td><span class="badge">Apoteker</span></td>
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