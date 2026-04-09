<?php
session_start();

if (!isset($_SESSION['cart'])) {
    header("Location: dashboard_kasir.php");
    exit;
}

$total = $_POST['total'];
$bayar = $_POST['bayar'];
$kembalian = $bayar - $total;

/* GENERATE KODE TRANSAKSI */
$kode_transaksi = "TRX" . date("YmdHis") . rand(10, 99);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <b>Struk Pembayaran</b>
            </div>

            <div class="content">

                <div class="card">
                    <h4 align="center">APOTEK SEHAT</h4>
                    <p align="center">Jl. Contoh No.1</p>
                    <hr>

                    <p><b>Kode Transaksi:</b> <?= $kode_transaksi ?></p>

                    <hr>

                    <?php foreach ($_SESSION['cart'] as $c): ?>
                        <?= $c['nama'] ?> (<?= $c['jumlah'] ?> x <?= $c['harga'] ?>)<br>
                    <?php endforeach; ?>

                    <hr>

                    <p>Total Harga : <b>Rp <?= $total ?></b></p>
                    <p>Nominal Bayar : <b>Rp <?= $bayar ?></b></p>
                    <p>Kembalian : <b>Rp <?= $kembalian ?></b></p>

                    <hr>

                    <p align="center">Terima kasih 🙏</p>

                    <a href="dashboard_kasir.php" class="btn">Transaksi Baru</a>

                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
unset($_SESSION['cart']);
?>