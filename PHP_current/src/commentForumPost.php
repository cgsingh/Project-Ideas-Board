<?php

/*
Group: 22
BTS630
File: commentForumPost.php
*/

session_start();

$errors = array(); 

//Validation variables
$dataValid = true;

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$forumPost = $_POST['commentField'];
$submitbutton= $_POST['comment_posted'];
$studentID = $_POST['studentId'];
$forumTopicID = $_POST['forumTopicId'];

//if user has posted a new project and double checking to make sure they're logged in
if ($_POST['commentField']){
	if ($_SESSION['id']){

//Test for nothing entered in field
        if ($_POST['commentField'] == "") {
            array_push($errors, "Comment is empty");
            $dataValid = false;
        }else{
            $dataValid = true;
        }
        
        if($dataValid){
            $sql_query = 'INSERT INTO FORUM_POSTS set StudentID="' . $studentID . 
        '", ForumParentPostID="0", 
        ForumTopicID="' . $forumTopicID . '",    
		ForumPost="' . htmlspecialchars($forumPost) .'"';

//Run our sql query
            $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            mysqli_free_result($result);
            mysqli_close($db);
		
//have this link to the project details page
            header("location: forumPostPage.php?id=".$forumTopicID."");
        }
    }else{
		mysqli_close($db);
		header("location: forumPage.php");
	}
}
?>