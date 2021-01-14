<?php

/*
Group: 22
BTS630
File: searchResults.php
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
            <h3 class="subTitle">Results for: <?php echo $_GET['search']; ?></h3>
            <ul class="projectList" id="projectList">
                <?php
                $sql_query = "SELECT * FROM PROJECT WHERE UPPER(Title) LIKE UPPER('%" . htmlspecialchars($_GET['search'], ENT_QUOTES) . "%')";
                $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                
                if($result->num_rows > 0 && strlen($_GET['search']) > 0){
                    while($row = $result->fetch_assoc()){
					echo '<li class="projectItem searchItem">';
					echo '<a class="aList" href="projectDetails.php?id=' . $row['ProjectID'] . '">';
					echo '<p class="projTitle">' . $row['Title'] . '</p>';
					$date = date_create($row['DateCreated']);
					echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
					echo '</a></li>';
                    }
                }
		else
		{
			echo '<li class="projectItem searchItem">';
			echo '<p class="projTitle" style="margin-bottom:10px;">0 Results Found!</p>';
			echo '</li>';

		}
                    
                mysqli_free_result($result);
        	 mysqli_close($db);
                ?>
            </ul>
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
	</body>
</html>