<?php

/*
Group: 22
BTS530
File: logout.php
*/

$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

$db = new mysqli($servername, $username, $password, $dbname);

$sql_query = 'DELETE FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_COOKIE['SSID'] . '";';
mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));

session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
setcookie("SSID", "", time() - 1, "/");

header("location: homePage.php");
?>