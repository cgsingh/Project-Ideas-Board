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
	
	if (isset($_COOKIE['SSID'])) {
		$sql_query = 'SELECT * FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_COOKIE['SSID'] . '";';
		$result = mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
		$row = mysqli_fetch_array($result);
		$curr_date = (new DateTime('today'))->format('y-m-d');
		$exp_date = new DateTime($row['DateExpires']);
		if ($curr_date < $exp_date) {
			$_SESSION['SSID'] = $_COOKIE['SSID'];
			$_SESSION['id'] = $row['ID'];
			$sql_query = 'SELECT * FROM USER WHERE StudentID = "' . $row["ID"] . '";';
			$result = mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
			$row = mysqli_fetch_array($result);
			setcookie("SSID", $_SESSION['SSID'], time() + 604800, "/");
		} else {
			setcookie("SSID", "", time() - 1, "/");
		}
	}

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
	</head>
	<body>
		<div class="navBar">
			<a class="navBarTitle" href="homePage.php">Project Ideas Board</a>
			<!-- if signed in -->
			<?php if ($_SESSION['username']) { ?>
			<div class="dropdown">
				<a class="navBarTab" href="settingsPage.php">Settings</a>
				<div class="dropdown-content" style="right:0;">
					<a class="dropdown-content-item" href="#">Link 1</a>
					<a class="dropdown-content-item" href="#">Link 2</a>
					<a class="dropdown-content-item" href="logout.php">Sign-out</a>
				</div>
			</div>
			<a class="navBarTab" href="notificationsPage.php">Notifications</a>
			<div class="dropdown">
				<a class="navBarTab" href="settingsPage.php"><?php echo $_SESSION['username'] . " ";?> Profile</a>
				<div class="dropdown-content">
					<a class="dropdown-content-item" href="myProjectsPage.php">My Projects</a>
					<a class="dropdown-content-item" href="groupsJoinedPage.php">My Groups</a>
				</div>
			</div>
			<a class="navBarTab" href="projectPost.php">New Project</a>
			<!-- else if not signed in -->
			<?php } else { ?>
			<a class="navBarTab" href="loginPage.php">Sign-in</a>
			<a class="navBarTab" href="registerPage.php">Sign-up</a>
			<?php } ?>
			<form action="searchResults.php?s=<?php echo $_GET['search'];?>" method="GET">
      			<input type="text" class="searchTextField" placeholder="Search..." name="search" style="float:left">
				<button type="submit" class= "searchButton" style="float:left">&#128269;</button>
    		</form>
		</div>
		
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
			$sql_query = 'SELECT PROJECT.StudentID, PROJECT.ProjectID, PROJECT.Title, PROJECT.Details, PROJECT.Tags, PROJECT.DateCreated, PROJECT.Likes, PROJECT.Dislikes, (PROJECT.Likes - PROJECT.Dislikes) as totalLD, PROJECT.Views, USER.Username FROM PROJECT INNER JOIN USER ON PROJECT.StudentID=USER.StudentID ORDER BY ' . $_SESSION['sortBy'];
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{
					echo '<a class="aList" href="projectDetails.php?id=' . $row["ProjectID"] . '">';
					echo '<li class="projectItem hvr-bounce-to-right">';
					echo '<p class="projTitle">' . urldecode($row["Title"]) . '</p>';
					echo '<p class="projAuthor">' . $row['Username'] . '</p>';
					$date = date_create($row["DateCreated"]);
					echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
					echo '<p class="projectIntro">' . urldecode(substr($row["Details"], 0, 200)) . '...</p><br/>';
					echo '<p class="projLikes">' . urldecode($row["Tags"]) . '</p><br/>';
					$likeRatio = ($row["Likes"] / ($row["Likes"] + $row["Dislikes"])) * 100;
					if (is_nan($likeRatio))
					{
						$likeRatio = 100;
					}
					echo '<p class="projLikes">' . round($likeRatio) . '% of users liked this!' . '</p><br/>';
					echo '<p class="projLikes">Views: ' . $row["Views"] . '</p>';
					echo '</li></a>';
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
		<span class="footerNote">BTS630 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
		<script>
		</script>
	</body>
</html>