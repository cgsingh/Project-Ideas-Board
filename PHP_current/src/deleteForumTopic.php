<?php

/*
Group: 22
BTS530
File: deleteForumTopic.php
- User rejcets the user request and the system deletes the request from request table
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

$forumTopicID = $_GET["id"];

$sql_query = "SELECT * FROM FORUM_TOPICS WHERE ForumTopicID='" . $forumTopicID . "'";               
$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
$row = mysqli_fetch_assoc($result);
$forumcategoryID = $row['ForumCategoryID'];
            
$sql_query3 = "DELETE FROM FORUM_POSTS WHERE ForumTopicID='" . $forumTopicID . "'";               
$result3 = mysqli_query($db, $sql_query3) or die('query failed'. mysqli_error($db));

$sql_query2 = "DELETE FROM FORUM_TOPICS WHERE ForumTopicID='" . $forumTopicID . "'";               
$result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));

mysqli_free_result($result);
mysqli_free_result($result2);
mysqli_free_result($result3);

mysqli_close($db);
header('location: forumTopicPage.php?id=' . $forumcategoryID);

?>