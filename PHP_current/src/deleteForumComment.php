<?php

session_start();


//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$projectID = $_POST['projectID'];
$commentID = $_POST['forumPostId'];

$query = "UPDATE FORUM_POSTS SET ForumPost = NULL, StudentID = NULL WHERE ForumPostID = " . $commentID . ";";
$result = mysqli_query($db, $query) or die('query failed' . $query . mysqli_error($db));

header("location: forumPostPage.php?id=".$projectID."");

?>