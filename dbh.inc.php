<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "ngwaabe";

$conn = new mysqli($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: ".mysqli_connect_error());
}
?>