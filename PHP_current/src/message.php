<?php

/*
Group: 22
BTS630
File: myProjectsPage.php
- Displays all user create projects as a list
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

    $errorMessage = ""; 
    
//connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);
	
	if ($_POST)
	{
		if ($_SESSION['id'])
		{
			if ($_POST['delete'])
			{
				$sql_query = "DELETE FROM INBOX WHERE INBOX.MessageID = " . $_POST['delete'];
				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
				mysqli_free_result($result);
				header("location: inbox.php");
			}
		}
	}

?>
<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/home.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php
			$sql_query = "UPDATE INBOX SET HasRead = 1 WHERE INBOX.MessageID = " . $_GET['id'] . " OR (INBOX.ParentMessageID = " . $_GET['id'] . " AND RecipientID = " . $_SESSION['id'] . ")";
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			mysqli_free_result($result);
			
			
			
			$sql_query = "SELECT Title FROM INBOX WHERE INBOX.MessageID = " . $_GET['id'];
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{
					$title = $row["Title"];
				}
			}
			mysqli_free_result($result);
		?>
		<?php include('navigationBar.php'); ?>
		
		<div class="projectPostContainer">
		<h2 class="subTitle"><?php echo $title; ?></h2>
		<!-- a listing similar to reddit -->
		<ul class="projectList" id="projectList">
		<?php
            
            $userID = $_SESSION['id'];
			
			//$sql_query = "SELECT INBOX.ParentMessageID, INBOX.ParentReplyID, INBOX.StudentID, INBOX.Title, INBOX.RecipientID, INBOX.DateCreated, INBOX.Body, INBOX.MessageID, INBOX.HasRead, USER.Username FROM INBOX INNER JOIN USER ON INBOX.StudentID = USER.StudentID WHERE INBOX.MessageID = " . $_GET['id'];
			$sql_query = "SELECT INBOX.ParentMessageID, INBOX.ParentReplyID, INBOX.StudentID, INBOX.Title, INBOX.RecipientID, INBOX.DateCreated, INBOX.Body, INBOX.MessageID, INBOX.HasRead, USER.Username FROM INBOX INNER JOIN USER ON INBOX.StudentID = USER.StudentID WHERE INBOX.ParentMessageID = " . $_GET['id'] . " OR INBOX.MessageID = " . $_GET['id'] . " ORDER BY INBOX.DateCreated DESC";
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{
					$parentReply = $row["MessageID"];
					if (!is_null($row["ParentReplyID"]))
					{
						$parentReply = $row["ParentReplyID"];
					}
					echo '<li class="projectItem searchItem hvr-bounce-to-right">';
					echo "<br/><br/>";
					$date = date_create($row["DateCreated"]);
					echo '<p class="projDate">' . 'Sent by <b>' . $row["Username"] . '</b> on ' . date_format($date, "F j, Y h:i:s") . '</p>';
					echo '<p class="projectIntro">' . $row["Body"] . '</p><br/>';
					$urlvars = "id=" . $row["StudentID"] . "&mid=" . $parentReply;
					if (!is_null($row["ParentMessageID"]))
					{
						$pid = "&pid=" . $row["ParentMessageID"];
					}
					else
					{
						$pid = "";
					}
					if ($row["StudentID"] != $_SESSION["id"])
					{
					?>
					<button class="formBtn" onclick="location.href='replyMessage.php?id=<?php echo $row["StudentID"] . "&mid=" . $row["MessageID"] . $pid; ?>'">Reply</button>
					<?php
					echo '<br/><br/>';
					}
					echo '</li>';
				}
			}
			else
			{
				header("location: inbox.php");
			}
			mysqli_free_result($result);
        	mysqli_close($db);


		?>
		</ul>
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
		<script>
		</script>
	</body>
</html>