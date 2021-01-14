<?php

function checkSession() {
//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);


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
			return true;
		} else {
			$sql_query = 'DELETE FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_COOKIE['SSID'] . '";';
			mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
			setcookie("SSID", "", time() - 1, "/");
			unset($_SESSION["id"]);
			unset($_SESSION["name"]);
			return false;
		}
	}
}
?>