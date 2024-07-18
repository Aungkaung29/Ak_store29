<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$connection = mysqli_connect('localhost', 'root', '', 'AK_store');

if (!$connection) {
    die('Connection error: ' . mysqli_connect_error());
}
?>
