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
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="manajer.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="dashboard_manajer.php" class="balek">←</a>
                Daftar Pengguna
            </div>
        </div>

        <div class="content">
            <div class="alert-info">
                ℹ️ Pilih role pengguna yang akan didaftarkan.
            </div>

            <a href="input_pengguna.php?role=Apoteker" class="menu-item" style="justify-content:space-between; background:white;">
                <div>
                    <b style="color:#9333ea;">Input Data Apoteker</b>
                    <p>Daftar Pengguna Baru Apoteker</p>
                </div>
                <span style="color:#ccc;">→</span>
            </a>

            <a href="input_pengguna.php?role=Kasir" class="menu-item" style="justify-content:space-between; background:white;">
                <div>
                    <b style="color:#10b981;">Input Data Kasir</b>
                    <p>Daftar Pengguna Baru Kasir</p>
                </div>
                <span style="color:#ccc;">→</span>
            </a>
        </div>
    </div>
</body>

</html>