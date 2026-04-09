<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {

    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $exp  = $_POST['exp'];
    $supplier = $_POST['supplier'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO obat 
(kode_obat,nama_obat,stok,expired,supplier,harga)
VALUES
('$kode','$nama','$stok','$exp','$supplier','$harga')");

    $msg = "Data berhasil disimpan";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Input Data Obat</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <a href="inventaris.php">←</a>
                <span>Input Data Obat</span>
            </div>

            <div class="card">

                <?php
                if (isset($msg)) {
                    echo $msg . "<br><br>";
                }
                ?>

                <form method="post">

                    <label>Kode Obat</label>
                    <input type="text" name="kode" required>

                    <label>Nama Obat</label>
                    <input type="text" name="nama" required>

                    <label>Jumlah Stok</label>
                    <input type="number" name="stok" required>

                    <label>Tanggal Kadaluarsa</label>
                    <input type="date" name="exp" required>

                    <label>Supplier</label>
                    <input type="text" name="supplier" required>

                    <label>Harga Beli</label>
                    <input type="number" name="harga" required>

                    <button class="btn" name="simpan">
                        Simpan Data Obat
                    </button>

                </form>

            </div>

        </div>
    </div>
</body>

</html>