<?php
$host = "localhost";
$user = "root";
$pass = "202312035";
$db   = "angel_beauty";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>