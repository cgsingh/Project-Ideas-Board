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
		<h2 class="subTitle">My Project Ideas</h2>
		<!-- a listing similar to reddit -->
		<ul class="projectList" id="projectList">
		<?php
            
            $userID = $_SESSION['id'];
			//projects are ordered by the following calculation: likes - dislikes.
			//highest value of that result will be at the top of the list, regardless of highest percentage ratio
			$sql_query = "SELECT DISTINCT PROJECT.ProjectID, 
            PROJECT.Title, 
            PROJECT.Details, 
            PROJECT.Tags, 
            PROJECT.DateCreated, 
            PROJECT.Likes, 
            PROJECT.Dislikes, 
            (PROJECT.Likes - PROJECT.Dislikes) as totalLD 
            FROM PROJECT 
            INNER JOIN USER ON PROJECT.StudentID='". $userID . "'";
			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc())
				{

					echo '<li class="projectItem searchItem hvr-bounce-to-right">';
					echo '<a class="aList" href="projectDetails.php?id=' . $row["ProjectID"] . '">';
					echo '<p class="projTitle">' . urldecode($row["Title"]) . '</p>';
					$date = date_create($row["DateCreated"]);
					echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
					echo '<p class="projectIntro">' . urldecode(substr($row["Details"], 0, 200)) . '...</p><br/>';
					echo '<p class="projLikes">' . $row["Tags"] . '</p><br/>';
					$likeRatio = ($row["Likes"] / ($row["Likes"] + $row["Dislikes"])) * 100;
					if (is_nan($likeRatio))
					{
						$likeRatio = 100;
					}
					echo '<p class="projLikes">' . round($likeRatio) . '% of users liked this!' . '</p>';
                    echo '<button class="formBtn"><a style="text-decoration:none;color:#FFFFFF;font-family:"Times New Roman";" href="projectEdit.php?projectid=' . $row["ProjectID"] . '">Edit</a></button>';
					echo ' <button class="formBtn"><a style="text-decoration:none;color:#FFFFFF;font-family:"Times New Roman";" href="deleteProject.php?projectid=' . $row["ProjectID"] . '">Delete</a></button><br/><br/>';
                    echo '<button class="formBtn"><a style="text-decoration:none;color:#FFFFFF;font-family:"Times New Roman";" href="myGroupMembersPage.php?projectid=' . $row["ProjectID"] . '">View Group Members</a></button>';
					echo '</a></li>';
				}
			}
			else
			{
				echo 'No Project Ideas have been created yet!';
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