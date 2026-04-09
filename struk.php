<?php
session_start();

if (!isset($_SESSION['cart'])) {
    header("Location: dashboard_kasir.php");
    exit;
}

$total = $_POST['total'];
$bayar = $_POST['bayar'];
$kembalian = $bayar - $total;

$kode_transaksi = "TRX" . date("YmdHis") . rand(10, 99);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran</title>
    <link rel="stylesheet" href="kasir.css?v=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="dashboard_kasir.php" class="balek">←</a>
                🛒 Transaksi Penjualan
            </div>
        </div>

        <div class="content">
            <div class="alert-success">
                ✔️ Transaksi Berhasil!
            </div>

            <div class="card" style="padding: 25px;">
                <div class="struk-header">
                    <h4>STRUK PEMBAYARAN</h4>
                    <p>APOTEK SEHAT</p>
                </div>

                <div class="dash-line"></div>

                <table class="struk-table">
                    <tr>
                        <td style="color:#777;">No. Transaksi</td>
                        <td><?= $kode_transaksi ?></td>
                    </tr>
                    <tr>
                        <td style="color:#777;">Tanggal</td>
                        <td><?= date("d/m/Y, H:i:s") ?></td>
                    </tr>
                </table>

                <div class="dash-line"></div>

                <table class="struk-table">
                    <?php foreach ($_SESSION['cart'] as $c): ?>
                        <tr>
                            <td colspan="2"><b><?= $c['nama'] ?></b></td>
                        </tr>
                        <tr>
                            <td style="color:#777;"><?= $c['jumlah'] ?> x <?= number_format($c['harga'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format($c['harga'] * $c['jumlah'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <div class="dash-line"></div>

                <table class="struk-table">
                    <tr>
                        <td style="color:#777;">Total</td>
                        <td style="color:#10b981; font-weight:bold;">Rp <?= number_format($total, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td style="color:#777;">Bayar</td>
                        <td>Rp <?= number_format($bayar, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td style="color:#777;">Kembalian</td>
                        <td style="color:#10b981; font-weight:bold;">Rp <?= number_format($kembalian, 0, ',', '.') ?></td>
                    </tr>
                </table>

                <div class="dash-line" style="margin-bottom: 20px;"></div>
                <p style="text-align: center; font-size: 10px; color: #aaa;">Terima kasih atas kunjungan Anda</p>
                <a href="dashboard_kasir.php" class="btn" style="margin-top: 20px;">Transaksi Baru</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php
unset($_SESSION['cart']);
?>