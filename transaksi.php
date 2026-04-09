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
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Transaksi</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <a href="dashboard_kasir.php" class="balek">←Dashboard</a>
                <b>Transaksi</b>
            </div>

            <div class="content">

                <div class="card">
                    <form method="post">
                        <label>Kode / Nama Obat</label>
                        <input type="text" name="kode" required>

                        <label>Jumlah</label>
                        <input type="number" name="jumlah" required>

                        <button class="btn" name="tambah">Tambah ke Keranjang</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>