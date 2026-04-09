<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {

    $no = $_POST['no'];
    $pasien = $_POST['pasien'];
    $obat = $_POST['obat'];
    $jumlah = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $dokter = $_POST['dokter'];

    mysqli_query($conn, "INSERT INTO resep 
(no_resep,nama_pasien,nama_obat,jumlah,tanggal,nama_dokter)
VALUES
('$no','$pasien','$obat','$jumlah','$tanggal','$dokter')");

    $msg = "Data resep berhasil disimpan";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Input Resep</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <a href="inventaris.php">←</a>
                <span>Input Data Resep</span>
            </div>

            <div class="card">

                <?php
                if (isset($msg)) {
                    echo $msg . "<br><br>";
                }
                ?>

                <form method="post">

                    <label>No Resep</label>
                    <input type="text" name="no" required>

                    <label>Nama Pasien</label>
                    <input type="text" name="pasien" required>

                    <label>Nama Obat</label>
                    <input type="text" name="obat" required>

                    <label>Jumlah</label>
                    <input type="number" name="jumlah" required>

                    <label>Tanggal Resep</label>
                    <input type="date" name="tanggal" required>

                    <label>Nama Dokter</label>
                    <input type="text" name="dokter" required>

                    <button class="btn" name="simpan">
                        Simpan Data Resep
                    </button>

                </form>

            </div>
        </div>
    </div>

</body>

</html>