<?php
session_start();
include "koneksi.php";
if ($_SESSION['role'] != "manajer") {
    header("Location: login.php");
    exit;
}

$step = isset($_GET['step']) ? $_GET['step'] : 1;
$jenis = isset($_POST['jenis']) ? $_POST['jenis'] : (isset($_GET['jenis']) ? $_GET['jenis'] : '');
$tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : '';

$laporan_sukses = false;
$pesan_error = ""; // Menampung pesan jika SQL error
$total_items = 0;
$total_trx = 0;
$top_obat = 'Tidak ada data';
$total_revenue = 0;
$periode_text = '';

if ($step == 3 && !empty($tanggal)) {
    // Menentukan batasan waktu berdasarkan jenis laporan
    if ($jenis == 'Harian') {
        $start_date = $tanggal . " 00:00:00";
        $end_date = $tanggal . " 23:59:59";
        $periode_text = date("d F Y", strtotime($tanggal));
    } elseif ($jenis == 'Mingguan') {
        $start = strtotime('monday this week', strtotime($tanggal));
        $end = strtotime('sunday this week', strtotime($tanggal));
        $start_date = date('Y-m-d', $start) . " 00:00:00";
        $end_date = date('Y-m-d', $end) . " 23:59:59";
        $periode_text = date("d M", $start) . " - " . date("d M Y", $end);
    } elseif ($jenis == 'Bulanan') {
        $start_date = date('Y-m-01', strtotime($tanggal)) . " 00:00:00";
        $end_date = date('Y-m-t', strtotime($tanggal)) . " 23:59:59";
        $periode_text = date("F Y", strtotime($tanggal));
    }

    // Menggunakan try-catch untuk mendeteksi kegagalan query SQL
    try {
        // 1. Hitung Total Transaksi
        $q_trx = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transaksi WHERE tanggal BETWEEN '$start_date' AND '$end_date'");
        $d_trx = mysqli_fetch_assoc($q_trx);
        $total_trx = $d_trx['total'] ?? 0;

        if ($total_trx > 0) {
            $laporan_sukses = true;

            // 2. Hitung Total Item Terjual
            $q_items = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM detail_transaksi JOIN transaksi ON detail_transaksi.kode_transaksi = transaksi.kode_transaksi WHERE transaksi.tanggal BETWEEN '$start_date' AND '$end_date'");
            $d_items = mysqli_fetch_assoc($q_items);
            $total_items = $d_items['total'] ?? 0;

            // 3. Cari Obat Terlaris
            $q_top = mysqli_query($conn, "SELECT nama_obat, SUM(jumlah) AS qty FROM detail_transaksi JOIN transaksi ON detail_transaksi.kode_transaksi = transaksi.kode_transaksi WHERE transaksi.tanggal BETWEEN '$start_date' AND '$end_date' GROUP BY nama_obat ORDER BY qty DESC LIMIT 1");
            $d_top = mysqli_fetch_assoc($q_top);
            $top_obat = $d_top['nama_obat'] ?? 'Tidak ada data';

            // 4. Hitung Total Pendapatan
            $q_rev = mysqli_query($conn, "SELECT SUM(total_harga) AS total FROM transaksi WHERE tanggal BETWEEN '$start_date' AND '$end_date'");
            $d_rev = mysqli_fetch_assoc($q_rev);
            $total_revenue = $d_rev['total'] ?? 0;
        }
    } catch (mysqli_sql_exception $e) {
        $laporan_sukses = false;
        $pesan_error = $e->getMessage(); // Tangkap pesan error dari database
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan & Analisis</title>
    <link rel="stylesheet" href="manajer.css?v=2">
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

            <?php if ($pesan_error != ""): ?>
                <div class="alert-danger" style="background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 15px; font-size: 13px;">
                    ❗ <b>Gagal Memuat Database:</b><br><span style="font-size:11px; font-family:monospace;"><?= $pesan_error ?></span>
                </div>
            <?php endif; ?>

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
                        <label>Pilih Tanggal Acuan Laporan (<?= htmlspecialchars($jenis) ?>)</label>
                        <input type="date" name="tanggal" required>

                        <button type="submit" class="btn">Generate Laporan</button>
                    </form>
                </div>
                <div class="alert-info" style="font-size:11px;">
                    ℹ️ Pilih tanggal acuan, sistem akan otomatis mengkalkulasi jangkauan data sesuai kriteria.
                </div>

            <?php elseif ($step == 3): ?>
                <?php if ($laporan_sukses): ?>
                    <div class="alert-success">✔️ <b>Laporan Berhasil Dibuat</b><br>Data komparasi ditemukan di database.</div>
                    <div class="card">
                        <div class="card-title">Ringkasan Laporan</div>
                        <table class="sys-info" style="margin-bottom:15px;">
                            <tr>
                                <td style="text-align:left;">Jenis Laporan</td>
                                <td><?= htmlspecialchars($jenis) ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Periode</td>
                                <td><?= htmlspecialchars($periode_text) ?></td>
                            </tr>
                        </table>

                        <div class="stat-grid">
                            <div class="stat-card bg-orange-light">
                                <p>Total Penjualan</p><b><?= $total_items ?> Item</b>
                            </div>
                            <div class="stat-card bg-blue-light">
                                <p>Total Transaksi</p><b><?= $total_trx ?> Trx</b>
                            </div>
                        </div>

                        <p style="font-size:12px; color:#777; margin-bottom:3px;">Obat Terlaris</p>
                        <div style="background:#f8fafc; padding:10px; border-radius:8px; font-weight:bold; color:#333; margin-bottom:15px; border:1px solid #eee;">
                            <?= htmlspecialchars($top_obat) ?>
                        </div>

                        <div class="stat-large">
                            <p>Total Pendapatan</p>
                            <b>Rp <?= number_format($total_revenue, 0, ',', '.') ?></b>
                        </div>
                    </div>
                    <a href="laporan_analisis.php" class="btn btn-gray" style="background: white; border: 1px solid #ccc; color:#333;">Buat Laporan Baru</a>

                <?php elseif ($pesan_error == ""): ?>
                    <div class="alert-danger">❗ <b>Data Tidak Ditemukan</b><br>Tidak ada riwayat transaksi penjualan pada periode ini.</div>
                    <div class="card">
                        <div class="card-title">Detail Pencarian</div>
                        <table class="sys-info">
                            <tr>
                                <td style="text-align:left;">Jenis Laporan</td>
                                <td><?= htmlspecialchars($jenis) ?></td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Tanggal Acuan</td>
                                <td><?= date("d/m/Y", strtotime($tanggal)) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="alert-warning" style="font-size:11px;">
                        💡 <b>Saran:</b> Lakukan transaksi penjualan terlebih dahulu di halaman Kasir pada tanggal tersebut agar data terekam di sistem.
                    </div>
                    <a href="laporan_analisis.php?step=2&jenis=<?= $jenis ?>" class="btn">Coba Lagi</a>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </div>
</body>

</html>