<?php

/*
Group: 22
BTS530
File: commentPost.php
*/

session_start();

$errors = array(); 

//Validation variables
$dataValid = true;
$valid = "false";

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$comment = $_POST['commentField'];
$studentID = $_POST['studentId'];
$projectID = $_POST['projectId'];
$replyID = $_POST['replyId'];
$notificationID = $_POST['notificationId'];

//if user has posted a new project and double checking to make sure they're logged in
if ($_POST['commentField']){
	if ($_SESSION['id']){

//Test for nothing entered in field
        if ($_POST['commentField'] == "") {
            array_push($errors, "Comment is empty");
            $dataValid = false;
            $valid = false; 
        }else{
            $dataValid = true;
        }
        
        if($valid){
			if ($replyID == 'x') {
				$sql_query = 'INSERT INTO COMMENTS set StudentID="' . $studentID . '", ProjectID="' . $projectID . '", Comment="' . htmlspecialchars($comment) .'"';
				$notficationQuery = 'INSERT INTO NOTIFICATIONS set NotificationID = NULL, StudentID=' . $notificationID . ', Notification="A user has replied to your post!", ProjectID=' . $projectID .';';
			} else {
				$sql_query = 'INSERT INTO COMMENTS set StudentID="' . $studentID . '", ProjectID="' . $projectID . '", ReplyID= "' . $replyID . '", Comment="' . htmlspecialchars($comment) .'"';
				$notficationQuery = 'INSERT INTO NOTIFICATIONS set NotificationID = NULL, StudentID=' . $notificationID . ', Notification="A user has replied to your comment!", ProjectID=' . $projectID .';';
			}
			
			
				mysqli_query($db, $sql_query) or die('comment query failed'. mysqli_error($db));
				mysqli_query($db, $notficationQuery) or die('notification query failed (' . $notificationID . ')'. mysqli_error($db));

//Run our sql query
			
            mysqli_free_result($result);
            mysqli_close($db);
		
//have this link to the project details page
            header("location: projectDetails.php?id=".$projectID."");
        }
    }else{
		mysqli_close($db);
		header("location: projectDetails.php?id=".$projectID."");
	}
}
?>