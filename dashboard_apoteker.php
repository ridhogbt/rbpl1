<?php
session_start();
if ($_SESSION['role'] != "apoteker") {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Apoteker</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <span>Dashboard Apoteker</span>
                <a href="logout.php" class="logout">Logout</a>
            </div>

            <div class="card">
                Login berhasil! <br>
                Selamat datang <b><?= $_SESSION['user']; ?></b>
            </div>

            <div class="card">
                <a href="inventaris.php" class="btn">
                    Manajemen Inventaris
                </a>
            </div>

            <div class="card">
                <b>Informasi Sistem</b><br><br>

                Role Pengguna : Apoteker <br>
                Status Login : Aktif <br>
                Waktu Login : <?= date("H:i:s"); ?>

            </div>

        </div>
    </div>
</body>

</html>