<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
?>
<h2>Login berhasil</h2>
<p>Role: <?= $_SESSION['role']; ?></p>