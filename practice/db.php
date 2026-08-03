<?php
$host = "localhost";
$port = 3307;
$user = "root";
$pass = "";
$dbname = "Fall2025_CW";

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
