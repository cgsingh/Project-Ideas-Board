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
$commentID = $_POST['commentID'];

$query = "UPDATE COMMENTS SET comment = NULL, StudentID = NULL WHERE CommentID = " . $commentID . ";";
$result = mysqli_query($db, $query) or die('query failed'. mysqli_error($db));

header("location: projectDetails.php?id=".$projectID."");

?>