<?php

/*
Group: 22
BTS530
File: forumTopicPage.php
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

//Get Forum Category based on ID
$forumCategoryID = $_GET["id"];

$sql_query_forum_category = "SELECT * FROM FORUM_CATEGORIES WHERE ForumCategoryID=" . $forumCategoryID . "";
$result_forum_category = mysqli_query($db, $sql_query_forum_category) or die('query failed'. mysqli_error($db));
$row2 = mysqli_fetch_assoc($result_forum_category);
$forumCategory = $row2['ForumCategory'];

//Get All Forum Topics Based on ID
$forumtopicids=array();
$forumtopictitles=array();
$forumtopicdates=array();
$forumtopicstudentids=array();

$sql_query_forum_topic = "SELECT * FROM FORUM_TOPICS WHERE ForumCategoryID=" . $forumCategoryID . "";
$result_forum_topic= mysqli_query($db, $sql_query_forum_topic) or die('query failed'. mysqli_error($db));

if($result_forum_topic->num_rows > 0){
    while($row = $result_forum_topic->fetch_assoc()){
        array_push($forumtopicids, $row['ForumTopicID']);
        array_push($forumtopictitles, $row['ForumTopicTitle']);
        array_push($forumtopicdates, $row['ForumTopicDate']);
        array_push($forumtopicstudentids, $row['StudentID']);
    }
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
            <?php 
            echo '<h2 class="subTitle">' . $forumCategory . '</h2>'; 
            ?>
            
            <button class="formBtn" style="width:250px;border:1px solid black">
                <?php
                echo '<a class="aList" href="createForumTopicPage.php?id=' . $forumCategoryID . '">CREATE FORUM TOPIC';   
                echo "</a>";
                ?>
            </button>
             
            <br>
            <!-- a listing similar to reddit -->
            <ul class="projectList" id="projectList">
                    
                <?php   
                
                $arrlen=count($forumtopicids);
    
                                    
                for($j=0;$j<$arrlen; $j++){
                    
                    $forumTopicTitle = $forumtopictitles[$j];
                    $forumTopicID = $forumtopicids[$j];    
                    $forumTopicDate = $forumtopicdates[$j];
                    $forumStudentID = $forumtopicstudentids[$j];
                    
                    echo '<li class="projectItem searchItem">';
					echo '<a class="aList" href="forumPostPage.php?id=' . $forumTopicID . '">';				
                    echo '<p class="projTitle">' . urldecode($forumTopicTitle) . '</p>';
                    
					echo '</a>';
                    
                    if ($forumStudentID == $_SESSION['id']){ 
                        
                        $forumTopicID = $forumtopicids[$j];
                        echo '<a class="aList" href="editForumTopicPage.php?id=' . $forumTopicID . '">';   
                        echo 'EDIT</a>';
                        echo '<br>';
                        echo '<a class="aList" href="deleteForumTopic.php?id=' . $forumTopicID . '">';   
                        echo 'DELETE</a>';
                    } 
                    
                    echo '</li>';
				}
                
                if($arrlen == 0){
                    echo 'No Posts have been created yet!';
                }
                    
                mysqli_free_result($result_forum_topic);
                mysqli_free_result($result_forum_category);
        		mysqli_close($db);
                ?>
            </ul>
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
	</body>
</html>