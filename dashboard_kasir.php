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
    <link rel="stylesheet" href="kasir.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app" >
        <div class="card" id="card-kasir">

            <div class="header" >

                <span class="title" style="color: black;">Dashboard Kasir</span>
                <a href="logout.php" class="logout">Logout</a>
            </div>

            

                <div class="card">
                    Login berhasil! Selamat datang <b><?= $_SESSION['user']; ?></b>
                </div>

                <div class="card">
                    <h4>Menu</h4>
                    <a href="transaksi.php" class="btn">Transaksi Penjualan</a>
                </div>

                <div class="card">
                    <p>Role: <b>Kasir</b></p>
                    <p>Status: Aktif</p>
                    <p>Waktu Login: <?= date("H:i:s"); ?></p>
                </div>

            
        </div>
    </div>
</body>

</html>