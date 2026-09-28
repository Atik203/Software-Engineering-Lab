<?php
require __DIR__ . '/config.php';

$conn = mysqli_connect($DB['host'], $DB['user'], $DB['pass'], $DB['name'], $DB['port']);

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
