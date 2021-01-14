<?php

/*
Group: 22
BTS530
File: projDetails.php
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

//if user has posted a new project and double checking to make sure they're logged in
if ($_POST)
{
		
	if (isset($_COOKIE['SSID'])) {
		$sql_query = 'SELECT * FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_COOKIE['SSID'] . '";';
		$result = mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
		$row = mysqli_fetch_array($result);
		$curr_date = (new DateTime('today'))->format('y-m-d');
		$exp_date = (new DateTime($row['DateExpires']))->format('y-m-d');
		if ($curr_date < $exp_date) {
			$_SESSION['SSID'] = $_COOKIE['SSID'];
			$_SESSION['id'] = $row['ID'];
			$sql_query = 'SELECT * FROM USER WHERE StudentID = "' . $row["ID"] . '";';
			$result = mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
			$row = mysqli_fetch_array($result);
			setcookie("SSID", $_SESSION['SSID'], time() + 604800, "/");
		} else {
			$sql_query = 'DELETE FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_COOKIE['SSID'] . '";';
			mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
			setcookie("SSID", "", time() - 1, "/");
			unset($_SESSION["id"]);
			unset($_SESSION["name"]);
		}
	}
	
	if ($_SESSION['id'])
	{

	
	if (isset($_POST['btnLike']) || isset($_POST['btnDislike']))
	{
		$sql_query = 'SELECT ProjectID, StudentID, LikeDislike FROM PROJECT_VOTES WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		if ($result->num_rows == 0)
		{
			$sql_query = 'INSERT INTO PROJECT_VOTES (`ProjectID`, `StudentID`, `LikeDislike`) VALUES (' . $_GET["id"] . ', ' . $_SESSION["id"] . ', 0)';
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		}

		$sql_query = 'SELECT ProjectID, StudentID, LikeDislike FROM PROJECT_VOTES WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		$row = $result->fetch_assoc();
		if ($result->num_rows > 0)
		{

		if (isset($_POST['btnLike']))
		{
	
			if ($row['LikeDislike'] == 1)
			{
				$sql_query = 'UPDATE PROJECT set Likes = Likes - 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));

			
		        	$sql_query = 'UPDATE PROJECT_VOTES set LikeDislike = 0 WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			}
			if ($row['LikeDislike'] == 0)
			{
				$sql_query = 'UPDATE PROJECT set Likes = Likes + 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			
		        	$sql_query = 'UPDATE PROJECT_VOTES set LikeDislike = 1 WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			}
			if ($row['LikeDislike'] == -1)
			{
				$sql_query = 'UPDATE PROJECT set Likes = Likes + 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));

				$sql_query = 'UPDATE PROJECT set Dislikes = Dislikes - 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			
		        	$sql_query = 'UPDATE PROJECT_VOTES set LikeDislike = 1 WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			}	
	
	
		}
		else if (isset($_POST['btnDislike']))
		{
			if ($row['LikeDislike'] == 1)
			{
				$sql_query = 'UPDATE PROJECT set Likes = Likes - 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));

				$sql_query = 'UPDATE PROJECT set Dislikes = Dislikes + 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));

			
		        	$sql_query = 'UPDATE PROJECT_VOTES set LikeDislike = -1 WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			}
			if ($row['LikeDislike'] == 0)
			{
				$sql_query = 'UPDATE PROJECT set Dislikes = Dislikes + 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));

			
		        	$sql_query = 'UPDATE PROJECT_VOTES set LikeDislike = -1 WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			}
			if ($row['LikeDislike'] == -1)
			{
				$sql_query = 'UPDATE PROJECT set Dislikes = Dislikes - 1 WHERE ProjectID=' . $_GET["id"];
       				$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			
		        	$sql_query = 'UPDATE PROJECT_VOTES set LikeDislike = 0 WHERE ProjectID = ' . $_GET["id"] . ' AND StudentID = ' . $_SESSION['id'];
        	        	$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
			}		
		}
		}

       		mysqli_free_result($result);
		mysqli_close($db);
		}
	}
}
?>
