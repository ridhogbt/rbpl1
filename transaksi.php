<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['tambah'])) {
    $kode = $_POST['kode'];
    $jumlah = $_POST['jumlah'];

    $q = mysqli_query($conn, "SELECT * FROM obat WHERE kode_obat='$kode' OR nama_obat LIKE '%$kode%'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $_SESSION['cart'][] = [
            "nama" => $data['nama_obat'],
            "harga" => $data['harga'],
            "jumlah" => $jumlah
        ];
        header("Location: keranjang.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Transaksi</title>
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
            <div class="card">
                <div class="card-title">Input Obat</div>
                <form method="post">
                    <label>Kode/Nama Obat</label>
                    <input type="text" name="kode" placeholder="OBT001 atau Paracetamol" required>

                    <label>Jumlah</label>
                    <input type="number" name="jumlah" placeholder="0" required>

                    <button class="btn" name="tambah">+ Tambah ke Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>