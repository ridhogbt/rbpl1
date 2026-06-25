<?php
session_start();
include "koneksi.php";
if ($_SESSION['role'] != "apoteker") {
    header("Location: login.php");
    exit;
}

$pesan = "";

// LOGIKA HAPUS DATA
if (isset($_GET['hapus'])) {
    $id_obat = intval($_GET['hapus']);
    $q_hapus = mysqli_query($conn, "DELETE FROM obat WHERE id=$id_obat");
    if ($q_hapus) {
        $pesan = "Data obat berhasil dihapus dari sistem.";
    }
}

// LOGIKA PENCARIAN
$keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
if ($keyword != "") {
    $q_obat = mysqli_query($conn, "SELECT * FROM obat WHERE nama_obat LIKE '%$keyword%' OR kode_obat LIKE '%$keyword%' ORDER BY nama_obat ASC");
} else {
    $q_obat = mysqli_query($conn, "SELECT * FROM obat ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Daftar Obat</title>
    <link rel="stylesheet" href="apoteker.css?v=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="inventaris.php" class="balek">←</a>
                💊 Daftar & Cari Obat
            </div>
        </div>

        <div class="content">
            <?php if ($pesan != ""): ?>
                <div class="alert-success">✔️ <?= $pesan ?></div>
            <?php endif; ?>

            <div class="card" style="padding: 12px;">
                <form method="get" action="daftar_obat.php" style="display:flex; gap:10px;">
                    <input type="text" name="cari" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari nama atau kode obat..." style="margin:0; padding:10px;">
                    <button type="submit" class="btn" style="width:auto; padding:10px 15px; margin:0;">Cari</button>
                </form>
            </div>

            <?php
            if (mysqli_num_rows($q_obat) > 0):
                while ($row = mysqli_fetch_assoc($q_obat)):
            ?>
                    <div class="card" style="padding: 15px; margin-bottom: 10px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                            <div>
                                <b style="color:#333; font-size:14px;"><?= htmlspecialchars($row['nama_obat']) ?></b>
                                <p style="font-size:11px; color:#777; margin-top:4px;">Kode: <?= htmlspecialchars($row['kode_obat']) ?> | Exp: <?= date("d/m/Y", strtotime($row['expired'])) ?></p>
                                <p style="font-size:12px; font-weight:bold; color:#10b981; margin-top:4px;">Stok: <?= $row['stok'] ?></p>
                            </div>
                            <a href="daftar_obat.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus obat ini secara permanen?')" style="background:#ef4444; color:white; text-decoration:none; padding:5px 10px; border-radius:6px; font-size:11px; font-weight:bold;">Hapus</a>
                        </div>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <div class="alert-info">Tidak ada data obat yang ditemukan.</div>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>