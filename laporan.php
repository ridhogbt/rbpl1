<?php
session_start();
include "koneksi.php";
if ($_SESSION['role'] != "teknisi") {
    header("Location: login.php");
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM laporan_gangguan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Gangguan</title>
    <link rel="stylesheet" href="teknisi.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="dashboard_teknisi.php" class="balek">←</a>
                ⚙️ Laporan Gangguan
            </div>
        </div>

        <div class="content">
            <div class="alert-info">
                ℹ️ Pilih laporan gangguan untuk melihat detail dan melakukan perbaikan.
            </div>

            <?php while ($row = mysqli_fetch_assoc($query)):
                $badge_class = ($row['status'] == 'Baru') ? 'badge-blue' : (($row['status'] == 'Selesai') ? 'badge-green' : 'badge-red');
                $priority_class = strtolower($row['prioritas']);
            ?>
                <a href="update_laporan.php?id=<?= $row['id'] ?>" class="laporan-item">
                    <div class="laporan-header">
                        <b><?= $row['id_laporan'] ?></b>
                        <span class="<?= $badge_class ?>"><?= $row['status'] ?></span>
                    </div>
                    <div class="laporan-title"><?= $row['judul'] ?></div>
                    <div class="priority <?= $priority_class ?>">
                        ⚠️ <?= $row['prioritas'] ?>
                    </div>
                    <div class="laporan-meta">
                        <span>Pengguna: <?= $row['pelapor'] ?></span>
                        <span>🕒 <?= date("d M Y, H:i", strtotime($row['tanggal'])) ?></span>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</body>

</html>