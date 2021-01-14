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
	
	if (!$_SESSION['max'])
	{
		$_SESSION['max'] = 3;
	}
	
	if ($_POST)
	{
		if ($_SESSION['id'])
		{
			if ($_POST['delete'])
			{
				$sql_query = 'SELECT StudentID FROM INBOX WHERE MessageID=' . $_POST['delete'];
						$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc())
							{
								$sid = $row["StudentID"];
							}
						}
						mysqli_free_result($result);
						if ($sid != $_SESSION['id'])
						{
				$sql_query = "UPDATE INBOX SET RecipientID=-1 WHERE INBOX.MessageID = " . $_POST['delete'];
				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
				mysqli_free_result($result);
						}
						else
						{
							$sql_query = "UPDATE INBOX SET HasReplied=0 WHERE INBOX.MessageID = " . $_POST['delete'];
				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
				mysqli_free_result($result);
						}
			}
			else if (isset($_POST['less']))
			{
				$_SESSION['max'] = $_SESSION['max'] - 3;
				if ($_SESSION['max'] < 3)
				{
					$_SESSION['max'] = 3;
				}
				header("Refresh:0");
			}
			else if (isset($_POST['more']))
			{
				$_SESSION['max'] = $_SESSION['max'] + 3;
				header("Refresh:0");
			}
		}
	}

?>
<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/home.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
		<script>
		scrollDown = function() {
   document.body.scrollTop = document.body.scrollHeight;
} 
		</script>
	</head>
	<body onload="scrollDown()">
		<?php include('navigationBar.php'); ?>
		
		<div class="projectPostContainer">
		<h2 class="subTitle">My Inbox</h2>
		<!-- a listing similar to reddit -->
		<ul class="projectList" id="projectList">
		<?php
            
            $userID = $_SESSION['id'];
			
			$sql_query = "SELECT INBOX.Title, INBOX.RecipientID, INBOX.DateCreated, INBOX.Body, INBOX.MessageID, INBOX.HasRead, USER.Username FROM INBOX INNER JOIN USER ON INBOX.StudentID = USER.StudentID WHERE INBOX.RecipientID = " . $_SESSION['id'] . " AND INBOX.ParentMessageID IS NULL OR (INBOX.StudentID = " . $_SESSION['id'] . " AND INBOX.HasReplied=1) ORDER BY INBOX.DateCreated DESC LIMIT " . $_SESSION['max'];
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{
					if ($row["HasRead"] == 0)
					{
						echo '<li class="projectItem searchItem hvr-bounce-to-right" style="font-weight:bold;">';
					}
					else
					{
						echo '<li class="projectItem searchItem hvr-bounce-to-right">';
					}
					echo '<a class="aList" href="message.php?id=' . $row["MessageID"] . '">';
					echo '<p class="projTitle">' . urldecode($row["Title"]) . '</p>';
					$date = date_create($row["DateCreated"]);
					echo '<p class="projDate">' . 'Sent by <b>' . $row["Username"] . '</b> on ' . date_format($date, "F j, Y h:i:s") . '</p>';
					echo '<p class="projectIntro">' . urldecode(substr($row["Body"], 0, 200)) . '...</p><br/>';
					echo '<form action="inbox.php" method="post">';
					echo '<button type="submit" name="delete" class="formBtn" value="' . $row["MessageID"] . '">Delete</button><br/>';
					echo '</form>';
					echo '</a></li>';
				}
			}
			else
			{
				echo 'No Messages Yet!';
			}
			mysqli_free_result($result);
        	mysqli_close($db);


		?>
		</ul>
		<form action="inbox.php" method="post">
		<button type="submit" name="less" class="formBtn"><<</button>
		<button type="submit" name="more" class="formBtn">>></button><br/>
		</form>
		<br/><br/><br/><br/>
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
		<script>
		</script>
	</body>
</html>