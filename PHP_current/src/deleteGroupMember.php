<?php

/*
Group: 22
BTS530
File: deleteGroupMember.php
- User deletes a group member from a group 
*/

session_start();

if ($_SESSION['id']=="") { 
    header('location: loginPage.php'); 
}

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$studentID = $_GET['id'];
$groupID = $_GET['gro'];

//Delete the group member
$sql_delete = "DELETE FROM GROUP_MEMBERS WHERE StudentID='" . $studentID . "' AND GroupID='" . $groupID . "'";               
$result_delete = mysqli_query($db, $sql_delete) or die('query failed'. mysqli_error($db));


//Get group name
$sql_query_group_name = "SELECT * FROM GROUP_LIST WHERE GroupID='" . $groupID . "'";    
$result_group_name = mysqli_query($db, $sql_query_group_name) or die('query failed'. mysqli_error($db));
$row = mysqli_fetch_assoc($result_group_name);
$groupName = $row['GroupName'];
$projectID = $row['ProjectID'];


//Get Username of Student
$sql_query_user = "SELECT * FROM USER WHERE StudentID='" . $studentID . "'";    
$result_user = mysqli_query($db, $sql_query_user) or die('query failed'. mysqli_error($db));
$row2 = mysqli_fetch_assoc($result_user);
$deletedUsername = $row2['Username'];

$notificationMessage1 = "You have deleted " . $deletedUsername . " from this group: " . $groupName . "";
$notificationMessage2 = "The group leader has deleted you from the group: " . $groupName . "";
                            
$sql_insert1 = 'INSERT INTO NOTIFICATIONS set NotificationID=NULL, 
StudentID="' . $_SESSION['id'] . '", 
Notification="' . $notificationMessage1 . '",
ProjectID="' . $projectID .'"';
                            
//Run our sql insert statement
$resultInsert1 = mysqli_query($db,  $sql_insert1)or die('query failed'. mysqli_error($db));
mysqli_free_result($resultInsert1);

$sql_insert2 = 'INSERT INTO NOTIFICATIONS set NotificationID=NULL, 
StudentID="' . $studentID . '", 
Notification="' . $notificationMessage2 . '",
ProjectID="' . $projectID .'"';

//Run our sql insert statement
$resultInsert2 = mysqli_query($db,  $sql_insert2)or die('query failed'. mysqli_error($db));
mysqli_free_result($resultInsert2);     

mysqli_free_result($result_delete);
mysqli_free_result($result_group_name);
mysqli_free_result($result_user);

mysqli_close($db);

header('location: projectDetails.php?id=' . $projectID);

//header('location: homePage.php');
?>