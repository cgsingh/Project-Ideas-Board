<?php

/*
Group: 22
BTS630
File: groupsJoinedPage.php
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
            <h2 class="subTitle">My Groups</h2>
            <!-- a listing similar to reddit -->
            <ul class="projectList" id="projectList">
                <?php
                $groupids=array();
                $groupnames=array();
                $projectids=array();
                $startDates=array();
                $userID = $_SESSION['id'];
                
                $sql_query = "SELECT * FROM GROUP_MEMBERS WHERE StudentID='". $userID . "'";
                $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                    array_push($groupids, $row['GroupID']);
                    }
                }
                                
                $arrlen=count($groupids);
                
                for( $i=0; $i<$arrlen; $i++){    
                    $sql_query2 = "SELECT GroupName, ProjectID, StartDate FROM GROUP_LIST
                    WHERE GroupID ='" .$groupids[$i]. "'";
                                                                    
                    $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));     
                                        
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()){
                            array_push($groupnames, $row2['GroupName']);
                            array_push($projectids, $row2['ProjectID']);
                            array_push($startDates, $row2['StartDate']);
                        }
                    }
                }
                                    
                for($j=0;$j<sizeof($groupnames); $j++){
                    
                    $projectID= $projectids[$j];
                    $groupname = $groupnames[$j];
                    $startDate = $startDates[$j];
                    
                    echo '<li class="projectItem searchItem">';
					echo '<a class="aList" href="projectDetails.php?id=' . $projectID . '">';
					echo '<p class="projTitle">' . urldecode($groupname) . '</p>';
					$date = date_create($startDate);
					echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
					echo '</a></li>';
				}
                
                if($arrlen == 0){
                     echo "You have not joined any groups!";
                }
                    
                mysqli_free_result($result);
                mysqli_free_result($result2);
        		mysqli_close($db);
                ?>
            </ul>
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
	</body>
</html>