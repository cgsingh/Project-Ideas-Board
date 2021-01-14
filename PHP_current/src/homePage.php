<?php

/*
Group: 22
BTS530
File: homePage.php
*/

session_start();

//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

    $errorMessage = ""; 
    
//connect to the database
	$db = new mysqli($servername, $username, $password, $dbname);
	
	include ('sessionCheck.php');

if ($_POST)
{
	if (isset($_POST['sortBtn']))
	{
		if ($_POST['sortBtn'] == "1")
		{
			$_SESSION["sortBy"] = 'totalLD DESC';
		}
		else if ($_POST['sortBtn'] == "2")
		{
			$_SESSION["sortBy"] = 'DateCreated DESC';
		}
		else
		{
			$_SESSION["sortBy"] = 'Views DESC';
		}
	}
}

if ($_SESSION['sortBy']=="")
{
	$_SESSION["sortBy"] = 'totalLD DESC';
}

?>
<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/home.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		
		<div class="projectPostContainer">
		<div class="tab">
		<form action = "homePage.php" method = "post">
		<button type="submit" class="tablinks" name="sortBtn" value="1" <?php if ($_SESSION['sortBy'] == 'totalLD DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>Top</button>
		<button type="submit" class="tablinks" name="sortBtn" value="2" <?php if ($_SESSION['sortBy'] == 'DateCreated DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>New</button>
		<button type="submit" class="tablinks" name="sortBtn" value="3" <?php if ($_SESSION['sortBy'] == 'Views DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>Views</button>
		</form>
		</div>
		<ul class="projectList" id="projectList">
		<?php
			$sql_query = 'SELECT PROJECT.ProjectID, PROJECT.Title, PROJECT.Details, PROJECT.Tags, PROJECT.DateCreated, PROJECT.Likes, PROJECT.Dislikes, (PROJECT.Likes - PROJECT.Dislikes) as totalLD, PROJECT.Views, USER.Username FROM PROJECT INNER JOIN USER ON PROJECT.StudentID=USER.StudentID ORDER BY ' . $_SESSION['sortBy'];
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{
					echo '<li class="projectItem hvr-bounce-to-right">';
					echo '<a class="aList" href="projectDetails.php?id=' . $row["ProjectID"] . '">';
					echo '<p class="projTitle">' . $row["Title"] . '</p>';
					echo '<p class="projAuthor">' . $row['Username'] . '</p>';
					$date = date_create($row["DateCreated"]);
					echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
					echo '<p class="projectIntro">' . substr($row["Details"], 0, 200) . '...</p><br/>';
					echo '<p class="projLikes">' . $row["Tags"] . '</p><br/>';
					$likeRatio = ($row["Likes"] / ($row["Likes"] + $row["Dislikes"])) * 100;
					if (is_nan($likeRatio))
					{
						$likeRatio = 100;
					}
					echo '<p class="projLikes">' . round($likeRatio) . '% of users liked this!' . '</p><br/>';
					echo '<p class="projLikes">Views: ' . $row["Views"] . '</p>';
					echo '</a></li>';
				}
			}
			else
			{
				echo 'error';
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