<?php
session_start();
if ($_SESSION['role'] != "manajer") {
    header("Location: login.php");
    exit;
}

$step = isset($_GET['step']) ? $_GET['step'] : 1;
$jenis = isset($_POST['jenis']) ? $_POST['jenis'] : (isset($_GET['jenis']) ? $_GET['jenis'] : '');
$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';

// Simulasi Data Laporan (karena tabel transaksi belum lengkap)
$laporan_sukses = false;
if ($step == 3 && !empty($tanggal)) {
    // Jika tanggal yang dipilih adalah hari Minggu (contoh simulasi gagal)
    if (date('w', strtotime($tanggal)) == 0) {
        $laporan_sukses = false;
    } else {
        $laporan_sukses = true;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan & Analisis</title>
    <link rel="stylesheet" href="manajer.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="<?= $step == 1 ? 'dashboard_manajer.php' : 'laporan_analisis.php?step=' . ($step - 1) . '&jenis=' . $jenis ?>" class="balek">←</a>
                📊 Laporan dan Analisis
            </div>
        </div>

        <div class="content">

            <?php if ($step == 1): ?>
                <div class="card">
                    <div class="card-title">Pilih Jenis Laporan</div>
                    <form action="laporan_analisis.php?step=2" method="post">
                        <label class="radio-box">
                            <input type="radio" name="jenis" value="Harian" required>
                            <div>Laporan Harian<p>Penjualan per hari</p>
                            </div>
                        </label>
                        <label class="radio-box">
                            <input type="radio" name="jenis" value="Mingguan">
                            <div>Laporan Mingguan<p>Penjualan per minggu</p>
                            </div>
                        </label>
                        <label class="radio-box">
                            <input type="radio" name="jenis" value="Bulanan">
                            <div>Laporan Bulanan<p>Penjualan per bulan</p>
                            </div>
                        </label>

                        <div class="alert-info" style="margin-top:15px; margin-bottom:0; font-size:11px;">
                            ℹ️ Pilih jenis laporan dan tentukan periode waktu untuk melihat analisis penjualan.
                        </div>
                        <button type="submit" class="btn" style="margin-top:15px;">Selanjutnya</button>
                    </form>
                </div>

            <?php elseif ($step == 2): ?>
                <div class="card">
                    <div class="card-title">Tentukan Rentang Waktu</div>
                    <form action="laporan_analisis.php?step=3&jenis=<?= $jenis ?>" method="post">
                        <input type="hidden" name="jenis" value="<?= htmlspecialchars($jenis) ?>">
                        <label>Pilih Tanggal (Laporan <?= htmlspecialchars($jenis) ?>)</label>
                        <input type="date" name="tanggal" required>

                        <button type="submit" class="btn btn-gray">Generate Laporan</button>
                    </form>
                </div>
                <div class="alert-info" style="font-size:11px;">
                    ℹ️ Pilih jenis laporan dan tentukan periode waktu untuk melihat analisis penjualan.
                </div>

            <?php elseif ($step == 3): ?>
                <?php if ($laporan_sukses): ?>
                    <div class="alert-success">✔️ <b>Laporan Berhasil Dibuat</b><br>Data ditemukan untuk periode yang dipilih.</div>
                    <div class="card">
                        <div class="card-title">Ringkasan Laporan</div>
                        <table class="sys-info" style="margin-bottom:15px;">
                            <tr>
                                <td style="text-align:left;">Jenis Laporan</td>
                                <td><?= $jenis ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Periode</td>
                                <td><?= date("d F Y", strtotime($tanggal)) ?></td>
                            </tr>
                        </table>

                        <div class="stat-grid">
                            <div class="stat-card bg-orange-light">
                                <p>Total Penjualan</p><b>45 Item</b>
                            </div>
                            <div class="stat-card bg-blue-light">
                                <p>Total Transaksi</p><b>23 Trx</b>
                            </div>
                        </div>

                        <p style="font-size:12px; color:#777; margin-bottom:3px;">Obat Terlaris</p>
                        <div style="background:#f8fafc; padding:10px; border-radius:8px; font-weight:bold; color:#333; margin-bottom:15px; border:1px solid #eee;">
                            Paracetamol 500mg
                        </div>

                        <div class="stat-large">
                            <p>Total Pendapatan</p>
                            <b>Rp 850.000</b>
                        </div>
                    </div>
                    <a href="laporan_analisis.php" class="btn btn-gray" style="background: white; border: 1px solid #ccc;">Buat Laporan Baru</a>

                <?php else: ?>
                    <div class="alert-danger">❗ <b>Data Tidak Ditemukan</b><br>Tidak ada data transaksi untuk periode yang dipilih.</div>
                    <div class="card">
                        <div class="card-title">Detail Pencarian</div>
                        <table class="sys-info">
                            <tr>
                                <td style="text-align:left;">Jenis Laporan</td>
                                <td><?= $jenis ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Periode</td>
                                <td><?= $tanggal ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="alert-warning" style="font-size:11px;">
                        💡 <b>Saran:</b> Coba pilih periode waktu yang berbeda atau pastikan ada transaksi pada periode tersebut.
                    </div>
                    <a href="laporan_analisis.php?step=2&jenis=<?= $jenis ?>" class="btn">Coba Lagi</a>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </div>
</body>

</html>