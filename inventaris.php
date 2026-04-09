<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manajemen Inventaris</title>
    <link rel="stylesheet" href="kasir.css">
</head>

<body>
    <div class="app">
        <div class="card">

            <div class="header">
                <a href="dashboard_apoteker.php">←</a>
                <span>Manajemen Inventaris</span>
            </div>

            <div class="card">
                Pilih jenis data yang ingin diinput ke sistem inventaris
            </div>

            <div class="card">
                <a href="input_obat.php" class="btn">
                    Input Data Obat
                </a>
            </div>

            <div class="card">
                <a href="input_resep.php" class="btn">
                    Input Data Resep
                </a>
            </div>

        </div>
    </div>
</body>

</html>