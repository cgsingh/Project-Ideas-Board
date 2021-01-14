<?php

/*
Group: 22
BTS630
File: forumPage.php
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
            <h2 class="subTitle">Forum</h2>
            <p>Click on one of the topics below</p>
                       
            <!-- a listing similar to reddit -->
            <ul class="projectList" id="projectList">
                    
                <?php          
                $forumcategories=array();
                $forumcategoryids=array();
                
                $sql_query = "SELECT * FROM FORUM_CATEGORIES";
                $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                    array_push($forumcategoryids, $row['ForumCategoryID']);
                    array_push($forumcategories, $row['ForumCategory']);
                    }
                }
                                
                $arrlen=count($forumcategoryids);
                                    
                for($j=0;$j<$arrlen; $j++){
                    
                    $forumCategoryID= $forumcategoryids[$j];
                    $forumCategory = $forumcategories[$j];
                    
                    echo '<li class="projectItem searchItem">';
					echo '<a class="aList" href="forumTopicPage.php?id=' . $forumCategoryID . '">';
					echo '<p class="projTitle">' . urldecode($forumCategory) . '</p>';
					echo '</a></li>';
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