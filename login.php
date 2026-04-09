<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role     = $_POST['role'];

    $query = mysqli_query($conn, "SELECT * FROM users 
WHERE username='$username' 
AND password='$password' 
AND role='$role'");

    $data = mysqli_fetch_assoc($query);

    if ($data) {

        $_SESSION['user'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == "kasir") {
            header("Location: dashboard_kasir.php");
            exit;
        } elseif ($data['role'] == "apoteker") {
            header("Location: dashboard_apoteker.php");
            exit;
        } elseif ($data['role'] == "manajer") {
            header("Location: dashboard_manajer.php");
            exit;
        } elseif ($data['role'] == "teknisi") {
            header("Location: dashboard_teknisi.php");
            exit;
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Apotek</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="card">

            <div class="logo">
                <img src="https://cdn-icons-png.flaticon.com/512/2966/2966486.png">
            </div>

            <h2>Sistem Manajemen Apotek</h2>
            <div class="subtitle">Silakan masuk untuk melanjutkan</div>

            <?php
            if (isset($error)) {
                echo "<div class='error'>$error</div>";
            }
            ?>

            <form method="post">

                <label>Username</label>
                <input type="text" name="username" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" name="login">Login</button>

                <div class="role-box">
                    <div class="role-title">Login sebagai</div>

                    <div class="roles">

                        <label>
                            <input type="radio" name="role" value="kasir" checked>
                            <span>Kasir</span>
                        </label>

                        <label>
                            <input type="radio" name="role" value="apoteker">
                            <span>Apoteker</span>
                        </label>

                        <label>
                            <input type="radio" name="role" value="manajer">
                            <span>Manajer</span>
                        </label>

                        <label>
                            <input type="radio" name="role" value="teknisi">
                            <span>Teknisi</span>
                        </label>

                    </div>
                </div>

            </form>

        </div>
    </div>

</body>

</html>