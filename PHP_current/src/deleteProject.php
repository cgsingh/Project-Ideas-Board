<?php

/*
Group: 22
BTS530
File: deleteProject.php
- User deletes a project
- Comments, group, group members, notifications and requests are deleted
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

//Project ID is retreived
$projectID = $_GET["projectid"];

//Delete All Comments
$sql_delete_comments = "DELETE FROM COMMENTS WHERE ProjectID='" . $projectID . "'";               
$result_delete_comments = mysqli_query($db, $sql_delete_comments) or die('query failed'. mysqli_error($db));

//Delete All Notifications
$sql_delete_notifications = "DELETE FROM NOTIFICATIONS WHERE ProjectID='" . $projectID . "'";               
$result_delete_notifications = mysqli_query($db, $sql_delete_notifications) or die('query failed'. mysqli_error($db));

//Delete All Requests
$sql_delete_requests = "DELETE FROM REQUESTS WHERE PROJECTID='" . $projectID . "'";               
$result_delete_requests = mysqli_query($db, $sql_delete_requests) or die('query failed'. mysqli_error($db));

//Query Group ID
$sql_query_group = "SELECT * FROM GROUP_LIST WHERE ProjectID='" . $projectID . "'";               
$result_group_query = mysqli_query($db, $sql_query_group) or die('query failed'. mysqli_error($db));
$row = mysqli_fetch_assoc($result_group_query);
$groupID = $row['GroupID'];

//Delete All Requests
$sql_delete_group_members = "DELETE FROM GROUP_MEMBERS WHERE GroupID='" . $groupID . "'";               
$result_delete_group_members = mysqli_query($db, $sql_delete_group_members) or die('query failed'. mysqli_error($db));

//Delete Group
$sql_delete_group = "DELETE FROM GROUP_LIST WHERE GroupID='" . $groupID . "'";               
$result_delete_group = mysqli_query($db, $sql_delete_group) or die('query failed'. mysqli_error($db));

//Delete Project
$sql_delete_project = "DELETE FROM PROJECT WHERE ProjectID='" . $projectID . "'";               
$result_delete_project = mysqli_query($db, $sql_delete_project) or die('query failed'. mysqli_error($db));

mysqli_free_result($result_delete_comments);
mysqli_free_result($result_delete_notifications);
mysqli_free_result($result_delete_requests);
mysqli_free_result($result_group_query);
mysqli_free_result($result_delete_group_members);
mysqli_free_result($result_delete_group);
mysqli_free_result($result_delete_project);

mysqli_close($db);

header('location: myProjectsPage.php');

?>