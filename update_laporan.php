<?php
session_start();
include "koneksi.php";
if ($_SESSION['role'] != "teknisi") {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM laporan_gangguan WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

// Logic untuk memproses form
if (isset($_POST['perbaiki']) || isset($_POST['eskalasi'])) {
    $catatan = $_POST['catatan'];
    $waktu = date('Y-m-d H:i:s');
    $status_baru = isset($_POST['perbaiki']) ? 'Selesai' : 'Perlu Eskalasi';

    mysqli_query($conn, "UPDATE laporan_gangguan SET status='$status_baru', catatan_perbaikan='$catatan', waktu_selesai='$waktu' WHERE id='$id'");

    // Refresh data setelah diupdate
    $query = mysqli_query($conn, "SELECT * FROM laporan_gangguan WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
}

// Logic untuk Navigasi UI
$is_detail = !isset($_GET['action']) && $data['status'] == 'Baru';
$is_form = isset($_GET['action']) && $_GET['action'] == 'mulai';
$is_done = $data['status'] == 'Selesai';
$is_escalated = $data['status'] == 'Perlu Eskalasi';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Detail Laporan</title>
    <link rel="stylesheet" href="teknisi.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="laporan.php" class="balek">←</a>
                ⚙️ <?= $is_done ? 'Hasil Perbaikan' : ($is_escalated ? 'Hasil Perbaikan' : ($is_form ? 'Update Status' : 'Detail Laporan')) ?>
            </div>
        </div>

        <div class="content">

            <?php if ($is_done): ?>
                <div class="alert-success">
                    ✔️ <b>Perbaikan Berhasil</b><br>Laporan telah diselesaikan dan dicatat dalam sistem.
                </div>
                <div class="card">
                    <div class="card-title">Ringkasan</div>
                    <table class="sys-info">
                        <tr>
                            <td>ID Laporan</td>
                            <td><?= $data['id_laporan'] ?></td>
                        </tr>
                        <tr>
                            <td>Status Akhir</td>
                            <td><span class="badge-green">Selesai</span></td>
                        </tr>
                        <tr>
                            <td>Waktu Selesai</td>
                            <td><?= date("d/m/Y, H:i:s", strtotime($data['waktu_selesai'])) ?></td>
                        </tr>
                    </table>
                    <div style="margin-top:15px; font-size:12px;">
                        <span style="color:#777;">Catatan Perbaikan:</span>
                        <div style="background:#f8fafc; padding:10px; border-radius:8px; margin-top:5px; border:1px solid #e2e8f0;"><?= $data['catatan_perbaikan'] ?></div>
                    </div>
                </div>
                <a href="laporan.php" class="btn">Kembali ke Daftar Laporan</a>

            <?php elseif ($is_escalated): ?>
                <div class="alert-danger">
                    ❗ <b>Perlu Eskalasi</b><br>Permasalahan lebih kompleks dan membutuhkan penanganan lebih lanjut.
                </div>
                <div class="card">
                    <div class="card-title">Ringkasan</div>
                    <table class="sys-info">
                        <tr>
                            <td>ID Laporan</td>
                            <td><?= $data['id_laporan'] ?></td>
                        </tr>
                        <tr>
                            <td>Status Akhir</td>
                            <td><span class="badge-red">Perlu Eskalasi</span></td>
                        </tr>
                        <tr>
                            <td>Waktu Update</td>
                            <td><?= date("d/m/Y, H:i:s", strtotime($data['waktu_selesai'])) ?></td>
                        </tr>
                    </table>
                    <div style="margin-top:15px; font-size:12px;">
                        <span style="color:#777;">Diagnosis / Temuan:</span>
                        <div style="background:#f8fafc; padding:10px; border-radius:8px; margin-top:5px; border:1px solid #e2e8f0;"><?= $data['catatan_perbaikan'] ?></div>
                    </div>
                    <div class="alert-warning" style="margin-top:15px; margin-bottom:0; font-size:11px;">
                        📌 Sistem telah mencatat laporan ini sebagai "Perlu Eskalasi" dan akan diteruskan ke tim yang lebih senior.
                    </div>
                </div>
                <a href="laporan.php" class="btn">Kembali ke Daftar Laporan</a>

            <?php elseif ($is_form): ?>
                <div class="card">
                    <table class="sys-info" style="margin-bottom:15px;">
                        <tr>
                            <td style="text-align:left;">ID Laporan</td>
                            <td><?= $data['id_laporan'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">Judul</td>
                            <td><?= $data['judul'] ?></td>
                        </tr>
                    </table>

                    <div class="card-title">Form Perbaikan</div>
                    <form method="post">
                        <label>Catatan Perbaikan / Diagnosis</label>
                        <textarea name="catatan" placeholder="Jelaskan tindakan yang telah dilakukan atau permasalahan yang ditemukan..." required></textarea>

                        <div class="alert-warning">⏳ Sistem menunggu update status dari Teknisi</div>

                        <button type="submit" name="perbaiki" class="btn btn-green">✔️ Gangguan Berhasil Diperbaiki</button>
                        <button type="submit" name="eskalasi" class="btn">❗ Perlu Eskalasi</button>
                    </form>
                </div>

            <?php else: ?>
                <div class="card">
                    <div class="card-title">Informasi Laporan</div>
                    <p style="font-size:12px; color:#777; margin-bottom:2px;">ID Laporan</p>
                    <p style="font-size:14px; font-weight:bold; margin-bottom:15px;"><?= $data['id_laporan'] ?></p>

                    <p style="font-size:12px; color:#777; margin-bottom:2px;">Status</p>
                    <p style="margin-bottom:15px;"><span class="badge-blue">Baru</span></p>

                    <table class="sys-info" style="margin-bottom:15px; border-top:1px solid #eee; padding-top:10px;">
                        <tr>
                            <td style="text-align:left; color:#777;">Judul</td>
                            <td style="font-weight:bold;"><?= $data['judul'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; color:#777;">Kategori</td>
                            <td><?= $data['kategori'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; color:#777;">Prioritas</td>
                            <td><span class="badge-red"><?= $data['prioritas'] ?></span></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; color:#777;">Dilaporkan Oleh</td>
                            <td><?= $data['pelapor'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left; color:#777;">Tanggal & Waktu</td>
                            <td><?= date("d M Y, H:i", strtotime($data['tanggal'])) ?></td>
                        </tr>
                    </table>

                    <p style="font-size:12px; color:#777; margin-bottom:5px;">Deskripsi Gangguan</p>
                    <div style="background:#f8fafc; padding:12px; border-radius:8px; font-size:13px; color:#333; line-height:1.5; border:1px solid #e2e8f0;">
                        <?= $data['deskripsi'] ?>
                    </div>
                </div>
                <a href="update_laporan.php?id=<?= $data['id'] ?>&action=mulai" class="btn">Mulai Perbaikan</a>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>