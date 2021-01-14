<?php

/*
Group: 22
BTS530
File: deleteNotification.php
- User deletes a notification
*/

session_start();

if ($_SESSION['id']=="") { 
    header('location: loginPage.php'); 
}

if($_GET["notificationid"]){

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$userID = $_SESSION['id'];
$notificationID = $_GET["notificationid"];

$sql_delete = "DELETE FROM NOTIFICATIONS WHERE StudentID='" . $userID . "' AND NotificationID='" . $notificationID . "'";               
$result = mysqli_query($db, $sql_delete) or die('query failed'. mysqli_error($db));
mysqli_free_result($result);
mysqli_free_result($result);     

mysqli_close($db);

header('location: notificationsPage.php');

}else{
  header('location: homePage.php');  
}


?>