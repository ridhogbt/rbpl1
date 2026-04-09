<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "rbpl_db";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal");
}
