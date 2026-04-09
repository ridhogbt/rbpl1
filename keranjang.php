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
    <link rel="stylesheet" href="kasir.css?v=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="transaksi.php" class="balek">←</a>
                🛒 Transaksi Penjualan
            </div>
        </div>

        <div class="content">
            <?php if (count($_SESSION['cart']) > 0): ?>
                <div class="alert-success">
                    ✔️ Item berhasil ditambahkan ke keranjang.
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-title">Daftar Item</div>

                <div class="item-list">
                    <?php
                    $total = 0;
                    if (count($_SESSION['cart']) == 0) {
                        echo "<p style='font-size:12px; color:#777;'>Keranjang masih kosong</p>";
                    } else {
                        foreach ($_SESSION['cart'] as $c) {
                            $sub = $c['harga'] * $c['jumlah'];
                            $total += $sub;
                            echo "
                            <div class='item'>
                                <div class='item-info'>
                                    <b>{$c['nama']}</b>
                                    <span>{$c['jumlah']} x Rp " . number_format($c['harga'], 0, ',', '.') . "</span>
                                </div>
                                <div class='item-price'>Rp " . number_format($sub, 0, ',', '.') . "</div>
                            </div>";
                        }
                    }
                    ?>
                </div>

                <div class="total-row">
                    <span>Total Belanja</span>
                    <span class="price">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
            </div>

            <?php if (count($_SESSION['cart']) > 0): ?>
                <div class="card">
                    <div class="card-title">Pembayaran</div>
                    <div class="total-row" style="background:#f0fdf4; padding:10px; border-radius:8px;">
                        <span style="color:#166534; font-size:13px; font-weight:normal;">Total Belanja</span>
                        <span style="color:#166534; font-size:14px;">Rp <?= number_format($total, 0, ',', '.') ?></span>
                    </div>

                    <form method="post" action="struk.php">
                        <label>Jumlah Pembayaran</label>
                        <input type="number" name="bayar" placeholder="0" required>
                        <input type="hidden" name="total" value="<?= $total ?>">

                        <button type="submit" class="btn">🖨️ Cetak Struk</button>
                        <a href="transaksi.php" class="btn-outline" style="color:#777; border-color:#ccc; margin-top:10px; text-align:center; display:block;">Kembali</a>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>