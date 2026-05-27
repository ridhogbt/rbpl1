<?php
session_start();
include "koneksi.php";
if ($_SESSION['role'] != "manajer") {
    header("Location: login.php");
    exit;
}

$pesan = "";
$tipe_pesan = "";

// LOGIKA UNTUK RESET PASSWORD
if (isset($_GET['action']) && $_GET['action'] == 'reset') {
    $id_user = intval($_GET['id']);
    $password_default = "12345";

    // Update password kembali ke default
    $query = mysqli_query($conn, "UPDATE users SET password='$password_default' WHERE id=$id_user");
    if ($query) {
        $pesan = "Password berhasil di-reset menjadi '12345'!";
        $tipe_pesan = "success";
    } else {
        $pesan = "Gagal mereset password.";
        $tipe_pesan = "danger";
    }
}

// LOGIKA UNTUK HAPUS AKUN (Melengkapi PBI-025)
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $id_user = intval($_GET['id']);
    $query = mysqli_query($conn, "DELETE FROM users WHERE id=$id_user");
    if ($query) {
        $pesan = "Akun berhasil dihapus!";
        $tipe_pesan = "success";
    }
}

// Ambil semua data pengguna kecuali manajer yang sedang login
$username_login = $_SESSION['user'];
$q_users = mysqli_query($conn, "SELECT * FROM users WHERE username != '$username_login' ORDER BY role ASC");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kelola Pengguna</title>
    <link rel="stylesheet" href="manajer.css?v=2">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .table-user {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 10px;
        }

        .table-user th {
            background: #f97316;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .table-user td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .btn-small {
            padding: 4px 8px;
            font-size: 11px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn-reset {
            background: #3b82f6;
        }

        .btn-hapus {
            background: #ef4444;
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <div class="app">
        <div class="header">
            <div class="header-title">
                <a href="dashboard_manajer.php" class="balek">←</a>
                👥 Kelola Pengguna
            </div>
        </div>

        <div class="content">
            <?php if ($pesan != ""): ?>
                <div class="alert-<?= $tipe_pesan ?>">
                    <?= $tipe_pesan == 'success' ? '✔️' : '❗' ?> <b>Info:</b> <?= $pesan ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-title">Daftar Akun Sistem</div>
                <div style="overflow-x: auto;">
                    <table class="table-user">
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($q_users)): ?>
                            <tr>
                                <td>
                                    <b><?= htmlspecialchars($row['username']) ?></b><br>
                                    <span style="color:#777; font-size:10px;"><?= htmlspecialchars($row['nama'] ?? '') ?></span>
                                </td>
                                <td><span class="badge"><?= ucfirst(htmlspecialchars($row['role'])) ?></span></td>
                                <td>
                                    <a href="kelola_pengguna.php?action=reset&id=<?= $row['id'] ?>" class="btn-small btn-reset" onclick="return confirm('Yakin ingin mereset password akun ini menjadi 12345?')">Reset Pass</a>
                                    <a href="kelola_pengguna.php?action=hapus&id=<?= $row['id'] ?>" class="btn-small btn-hapus" onclick="return confirm('Peringatan: Akun akan dihapus permanen. Lanjutkan?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>
            </div>

            <a href="daftar_pengguna.php" class="btn">Tambah Pengguna Baru</a>
        </div>
    </div>
</body>

</html>