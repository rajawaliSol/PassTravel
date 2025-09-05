<?php
$host = "localhost";
$user = "indopass_userpasstravel";
$pass = "sandacof0388";
$db   = "indopass_passtravel";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
