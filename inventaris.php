<?php
session_start();
if ($_SESSION['role'] != "apoteker") {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Inventaris</title>
    <link rel="stylesheet" href="apoteker.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="dashboard_apoteker.php" class="balek">←</a> 
                📦 Manajemen Inventaris
            </div>
        </div>

        <div class="content">
            <div class="alert-info">
                ℹ️ Pilih jenis data yang ingin diinputkan ke dalam sistem inventaris
            </div>

            <a href="input_obat.php" class="menu-item">
                <div class="icon">💊</div>
                <div>
                    <b>Input Data Obat</b>
                    <p>Tambah stok obat ke inventaris</p>
                </div>
            </a>

            <a href="input_resep.php" class="menu-item">
                <div class="icon-green">📄</div>
                <div>
                    <b>Input Data Resep</b>
                    <p>Catat resep dokter untuk pasien</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>