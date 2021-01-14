<?php

/*
Group: 22
BTS630
File: settingsPage.php
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
            <h2 class="subTitle">Settings</h2>
            <!-- a listing similar to reddit -->
            <ul class="projectList" id="projectList">
                <?php

                $userID = $_SESSION['id'];        
                
                echo '<li class="projectItem searchItem">';
				echo '<a class="aList" href="profileEdit.php">';
				echo '<p class="projTitle" style="margin-bottom:10px;">Edit Profile</p>';
				echo '</a></li>';
                
                echo '<li class="projectItem searchItem">';
				echo '<a class="aList" href="enterPassword.php">';
				echo '<p class="projTitle" style="margin-bottom:10px;">Change Password</p>';
				echo '</a></li>';
                
                echo '<li class="projectItem searchItem">';
				echo '<a class="aList" href="homePage.php">';
				echo '<p class="projTitle" style="margin-bottom:10px;">Deactivate Account (TBD)</p>';
				echo '</a></li>';			
                ?>
            </ul>
            
            <h2 class="subTitle">Functions for Administrator *Not yet developed*</h2>
            
            <ul class="projectList" id="projectList">
                <?php
          
                echo '<li class="projectItem searchItem">';
				echo '<a class="aList" href="homePage.php">';
				echo '<p class="projTitle" style="margin-bottom:10px;">View All Users</p>';
				echo '</a></li>';
                
                echo '<li class="projectItem searchItem">';
				echo '<a class="aList" href="homePage.php">';
				echo '<p class="projTitle" style="margin-bottom:10px;">View All Project Posts</p>';
				echo '</a></li>';
                
                echo '<li class="projectItem searchItem">';
				echo '<a class="aList" href="homePage.php">';
				echo '<p class="projTitle" style="margin-bottom:10px;">View All Comments</p>';
				echo '</a></li>';
                           			
                ?>
            </ul>
            
            
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
	</body>
</html>