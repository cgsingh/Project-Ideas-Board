<?php

/*
Group: 22
BTS530
File: acceptRequest.php
- User inserts a new group member and the system deletes the request from request table
*/

session_start();

if ($_SESSION['id'] == ""){ 
    header('location: loginPage.php'); 
}

$errors = array(); 

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$userIDrequest = $_GET["id"];
$projectID = $_GET["proj"];
$groupID = $_GET["group"];

$sql_query = "INSERT INTO GROUP_MEMBERS set GroupID='" . $groupID . "', StudentID='" . $userIDrequest . "'";               
$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
mysqli_free_result($result);

$sql_query3 = "SELECT * FROM USER WHERE StudentID='" . $userIDrequest . "'";    
$result3 = mysqli_query($db, $sql_query3) or die('query failed'. mysqli_error($db));
$row = mysqli_fetch_assoc($result3);
$requestUsername = $row['Username'];
mysqli_free_result($result3);

$sql_query4 = "SELECT * FROM GROUP_LIST WHERE ProjectID='" . $projectID . "'";    
$result4 = mysqli_query($db, $sql_query4) or die('query failed'. mysqli_error($db));
$row2 = mysqli_fetch_assoc($result4);
$projectName = $row2['GroupName'];
mysqli_free_result($result4);

$sql_query2 = "DELETE FROM REQUESTS WHERE USERID='" . $userIDrequest . "' AND PROJECTID='" . $projectID . "'";               
$result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
mysqli_free_result($result2);

//echo 'alert("User has been added to group")';

$notificationMessage1 = "You have accepted " . $requestUsername . " to join this project: " . $projectName . "";
$notificationMessage2 = "You have been added to join this group: " . $projectName . "";
                            
$sql_insert1 = 'INSERT INTO NOTIFICATIONS set NotificationID=NULL, 
StudentID="' . $_SESSION['id'] . '", 
Notification="' . $notificationMessage1 . '",
ProjectID="' . $projectID .'"';
                            
//Run our sql insert statement
$resultInsert1 = mysqli_query($db,  $sql_insert1)or die('query failed'. mysqli_error($db));;
mysqli_free_result($resultInsert1);

$sql_insert2 = 'INSERT INTO NOTIFICATIONS set NotificationID=NULL, 
StudentID="' . $userIDrequest . '", 
Notification="' . $notificationMessage2 . '",
ProjectID="' . $projectID .'"';

//Run our sql insert statement
$resultInsert2 = mysqli_query($db,  $sql_insert2)or die('query failed'. mysqli_error($db));;
mysqli_free_result($resultInsert2);     

mysqli_close($db);

header('location: projectDetails.php?id=' . $projectID);

?>
 