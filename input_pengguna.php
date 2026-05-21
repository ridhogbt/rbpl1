<?php
session_start();
include "koneksi.php";
if ($_SESSION['role'] != "manajer") {
    header("Location: login.php");
    exit;
}

$role_pilihan = isset($_GET['role']) ? $_GET['role'] : 'Pegawai';
$sukses = false;

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode']; // Disimpan sebagai username
    $nama = $_POST['nama'];
    $role = strtolower($_POST['role']); // kasir atau apoteker
    $tgl_lahir = $_POST['tanggal_lahir'];
    $domisili = $_POST['domisili'];
    $password_default = "12345"; // Default password untuk pengguna baru

    // Simpan ke database
    $query = mysqli_query($conn, "INSERT INTO users (username, password, nama, role, tanggal_lahir, domisili) VALUES ('$kode', '$password_default', '$nama', '$role', '$tgl_lahir', '$domisili')");

    if ($query) {
        $sukses = true;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Input Data <?= $role_pilihan ?></title>
    <link rel="stylesheet" href="manajer.css?v=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="<?= $sukses ? 'daftar_pengguna.php' : 'daftar_pengguna.php' ?>" class="balek">←</a>
                <?= $sukses ? 'Berhasil Disimpan' : 'Input Data ' . $role_pilihan ?>
            </div>
        </div>

        <div class="content">
            <?php if ($sukses): ?>
                <div class="alert-success">✔️ <b>Data Berhasil Disimpan</b><br>Data telah berhasil ditambahkan ke database.</div>

                <div class="card">
                    <div class="card-title">Ringkasan Data</div>
                    <table class="sys-info">
                        <tr>
                            <td style="text-align:left;">Kode (Username)</td>
                            <td><?= htmlspecialchars($kode) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">Nama</td>
                            <td><?= htmlspecialchars($nama) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">Role</td>
                            <td><?= htmlspecialchars(ucfirst($role)) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">Tanggal Lahir</td>
                            <td><?= date("d/m/Y", strtotime($tgl_lahir)) ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:left;">Domisili</td>
                            <td><?= htmlspecialchars($domisili) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="alert-warning" style="font-size:11px;">Password default pengguna ini adalah: <b>12345</b></div>
                <a href="input_pengguna.php?role=<?= $role_pilihan ?>" class="btn">Input Data Baru</a>

            <?php else: ?>
                <div class="card">
                    <div class="card-title">Form Data</div>
                    <form method="post">
                        <label>Kode (Username) *</label>
                        <input type="text" name="kode" placeholder="KSR001" required>

                        <label>Nama *</label>
                        <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>

                        <label>Role *</label>
                        <input type="text" name="role" value="<?= $role_pilihan ?>" readonly style="background:#eee;">

                        <label>Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" required>

                        <label>Domisili *</label>
                        <input type="text" name="domisili" placeholder="Kota domisili" required>

                        <button type="submit" name="simpan" class="btn">Simpan Data <?= $role_pilihan ?></button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>