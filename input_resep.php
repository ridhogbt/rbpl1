<?php
session_start();
include "koneksi.php";

$sukses = false;

if (isset($_POST['simpan'])) {
    $no = $_POST['no'];
    $pasien = $_POST['pasien'];
    $obat = $_POST['obat'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $dokter = $_POST['dokter'];

    $query = mysqli_query($conn, "INSERT INTO resep (no_resep,nama_pasien,nama_obat,jumlah,tanggal,nama_dokter) VALUES ('$no','$pasien','$obat','$jumlah','$tanggal','$dokter')");

    if($query){
        $sukses = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Input Resep</title>
    <link rel="stylesheet" href="apoteker.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="inventaris.php" class="balek">←</a> 
                <?= $sukses ? '✔️ Berhasil Disimpan' : '📄 Input Data Resep' ?>
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
                        <tr><td>No Resep</td><td><?= htmlspecialchars($no) ?></td></tr>
                        <tr><td>Nama Pasien</td><td><?= htmlspecialchars($pasien) ?></td></tr>
                        <tr><td>Nama Obat</td><td><?= htmlspecialchars($obat) ?></td></tr>
                        <tr><td>Jumlah</td><td><?= htmlspecialchars($jumlah) ?></td></tr>
                        <tr><td>Tanggal Resep</td><td><?= htmlspecialchars($tanggal) ?></td></tr>
                        <tr><td>Nama Dokter</td><td><?= htmlspecialchars($dokter) ?></td></tr>
                    </table>
                </div>

                <a href="input_resep.php" class="btn">Input Data Baru</a>
                
            <?php else: ?>
                <div class="card">
                    <div class="card-title">Form Data Resep</div>
                    <form method="post">
                        <label>No. Resep *</label>
                        <input type="text" name="no" placeholder="RAP11" required>

                        <label>Nama Pasien *</label>
                        <input type="text" name="pasien" placeholder="Deo" required>

                        <label>Nama Obat *</label>
                        <input type="text" name="obat" placeholder="Amoxicillin 500mg" required>

                        <label>Jumlah *</label>
                        <input type="number" name="jumlah" placeholder="3" required>

                        <label>Tanggal Resep *</label>
                        <input type="date" name="tanggal" required>

                        <label>Nama Dokter *</label>
                        <input type="text" name="dokter" placeholder="Dr. Randes" required>

                        <button class="btn btn-green" name="simpan">Simpan Data Resep</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>