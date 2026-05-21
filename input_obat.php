<?php
session_start();
include "koneksi.php";

$sukses = false;

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $exp  = $_POST['exp'];
    $supplier = $_POST['supplier'];
    $harga = $_POST['harga'];

    $query = mysqli_query($conn, "INSERT INTO obat (kode_obat,nama_obat,stok,expired,supplier,harga) VALUES ('$kode','$nama','$stok','$exp','$supplier','$harga')");

    if ($query) {
        $sukses = true;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Input Data Obat</title>
    <link rel="stylesheet" href="apoteker.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="inventaris.php" class="balek">←</a>
                <?= $sukses ? '✔️ Berhasil Disimpan' : '💊 Input Data Obat' ?>
            </div>
        </div>

        <div class="content">
            <?php if ($sukses): ?>
                <div class="alert-success">
                    ✔️ <b>Data Berhasil Disimpan</b><br>
                    Data telah berhasil ditambahkan ke database.
                </div>

                <div class="card">
                    <div class="card-title">Ringkasan Data</div>
                    <table class="sys-info summary-table">
                        <tr>
                            <td>Kode Obat</td>
                            <td><?= htmlspecialchars($kode) ?></td>
                        </tr>
                        <tr>
                            <td>Nama Obat</td>
                            <td><?= htmlspecialchars($nama) ?></td>
                        </tr>
                        <tr>
                            <td>Jumlah Stok</td>
                            <td><?= htmlspecialchars($stok) ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Kadaluarsa</td>
                            <td><?= htmlspecialchars($exp) ?></td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td><?= htmlspecialchars($supplier) ?></td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>

                <a href="input_obat.php" class="btn">Input Data Baru</a>

            <?php else: ?>
                <div class="card">
                    <div class="card-title">Form Data Obat</div>
                    <form method="post">
                        <label>Kode Obat *</label>
                        <input type="text" name="kode" placeholder="OBT001" required>

                        <label>Nama Obat *</label>
                        <input type="text" name="nama" placeholder="Paracetamol 500mg" required>

                        <label>Jumlah Stok *</label>
                        <input type="number" name="stok" placeholder="100" required>

                        <label>Tanggal Kadaluarsa *</label>
                        <input type="date" name="exp" required>

                        <label>Supplier *</label>
                        <input type="text" name="supplier" placeholder="PT. Kimia Farma" required>

                        <label>Harga Beli (Rp) *</label>
                        <input type="number" name="harga" placeholder="5000" required>

                        <button class="btn" name="simpan">Simpan Data Obat</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>