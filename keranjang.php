<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Keranjang</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <div class="card">...</div>
                <a href="transaksi.php">←Kembali</a>
                <b>Keranjang</b>
            </div>

            <div class="content">

                <div class="card">
                    <h4>Daftar Item</h4>

                    <?php
                    $total = 0;

                    if (count($_SESSION['cart']) == 0) {
                        echo "<p>Keranjang masih kosong</p>";
                    } else {
                        foreach ($_SESSION['cart'] as $c) {
                            $sub = $c['harga'] * $c['jumlah'];
                            $total += $sub;

                            echo "<div class='item'>
            <b>{$c['nama']}</b><br>
            {$c['jumlah']} x Rp {$c['harga']}<br>
            <span class='price'>Rp {$sub}</span>
        </div>";
                        }
                    }
                    ?>

                    <div class="total">
                        <span>Total</span>
                        <span>Rp <?= $total ?></span>
                    </div>

                    <?php if (count($_SESSION['cart']) > 0): ?>
                        <hr>

                        <form method="post" action="struk.php">
                            <label>Nominal Pembayaran</label>
                            <input type="number" name="bayar" placeholder="Masukkan uang pelanggan" required>

                            <input type="hidden" name="total" value="<?= $total ?>">

                            <button type="submit" class="btn">Proses Pembayaran</button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</body>

</html>