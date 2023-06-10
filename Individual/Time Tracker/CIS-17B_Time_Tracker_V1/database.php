<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "time_tracker";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if(!$conn) {
    die("Error");
}