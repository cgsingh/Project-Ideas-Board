<?php

/*
Group: 22
BTS530
File: forumPostPage.php
*/

//include('projDetails.php');

//if ($_POST['commentField'])
//{
    //include('commentPost.php');
//}

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
	
    <?php
    
    $forumTopicID = $_GET["tid"];
    $forumReplyParentPostID = $_GET["id"];
    
    if($forumTopicID == NULL){
        header("location: homePage.php");
    }
    
    
    //Get all Forum Topic Information
    $sql_query_forum_topic = "SELECT * FROM FORUM_TOPICS WHERE ForumTopicID=" . $forumTopicID . "";
    $result_forum_topic = mysqli_query($db, $sql_query_forum_topic) or die('query failed'. mysqli_error($db));
    $row = mysqli_fetch_assoc($result_forum_topic);
    $forumCategoryID = $row['ForumCategoryID'];
    $forumTopicStudentID = $row['StudentID'];
    $forumTopicDate = $row['ForumTopicDate'];
    $forumTopicDescription = $row['ForumTopicDescription'];
    $forumTopicTitle = $row['ForumTopicTitle'];
    $forumTopicActive = $row['ActiveForumTopic'];
    mysqli_free_result($result_forum_topic);
    
    if($forumTopicActive == 0){
        header("location: forumPostPage.php?id=".$forumTopicID."");
    }
    
    //Get the Name of the Forum Category
    $sql_query_forum_category = "SELECT * FROM FORUM_CATEGORIES WHERE ForumCategoryID=" . $forumCategoryID . "";
    $result_forum_category = mysqli_query($db, $sql_query_forum_category) or die('query failed'. mysqli_error($db));
    $row2 = mysqli_fetch_assoc($result_forum_category);
    $forumCategory = $row2['ForumCategory'];
    mysqli_free_result($result_forum_category);
    
    //Get all posts related to forum topic
    $sql_query_forum_post = "SELECT * FROM FORUM_POSTS WHERE ForumTopicID=" . $forumTopicID . " ORDER BY FORUM_POSTS.ForumPostDate";
    $result_forum_post = mysqli_query($db, $sql_query_forum_post) or die('query failed'. mysqli_error($db));
    $numPosts = $result_forum_post->num_rows;
    
    $forumpostids=array();
    $forumparentpostids=array();
    $forumposts=array();
    $forumpostdates=array();
    $forumpoststudentids=array();
    
    if($result_forum_post->num_rows > 0){
        while($row3 = $result_forum_post->fetch_assoc()){
            array_push($forumpostids, $row3['ForumPostID']);
            array_push($forumparentpostids, $row3['ForumParentPostID']);
            array_push($forumposts, $row3['ForumPost']);
            array_push($forumpostdates, $row3['ForumPostDate']);
            array_push($forumpoststudentids, $row3['StudentID']);
        }
    }

    mysqli_free_result($result_forum_post);
    
    //Get the name of the student related to the topic
    $sql_query_forum_topic_studentID = "SELECT * FROM USER WHERE StudentID=" . $forumTopicStudentID . "";
    $result_forum_topic_studentID = mysqli_query($db, $sql_query_forum_topic_studentID) or die('query failed'. mysqli_error($db));
    $row4 = mysqli_fetch_assoc($result_forum_topic_studentID);
    $username_forum_topic = $row4['Username'];
    mysqli_free_result($result_forum_topic_studentID);
    
    
    //COMMENT POSTED
    if ($_POST['commentField']){
        include('createReplyForumPost.php');
    }
    
    ?>
	

	
	<div style="margin-top:50px;width:60%;padding-left:8px;padding-top:8px;padding-bottom:8px;text-align:left;background-color:#758ab6;margin-left:66px;color:black;">
	<?php
        echo '<h2 style="margin-top:-5px;text-align:center;">' . $forumTopicTitle . '</h2>';
        echo '<p style="margin-top:-6px;text-align:center;">Topic created by <a style="text-decoration:none;" href="profilePage.php?id=' . $forumTopicStudentID . '">@' . $username_forum_topic . '</a> on ';
        $date = date_create($forumTopicDate);
        echo date_format($date, "F j, Y") . '</p>';
        echo '<p class="projectIntro" style="margin-left:0px;text-align:center;">' . $forumTopicDescription . '</p><br/>';
            
        echo 'Posts <span style="color:black;font-weight:bold;background-color:green;border-radius:50%;padding:6px;padding-left:11px;padding-right:11px;">' . $numPosts . '</span>';    
    ?>
        
    </div>

<br/>
    
    <div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:center;width:calc(60% + 8px);word-wrap:break-word;">

<?php
    
    $arrlen=count($forumpostids);
    
    for($i=0;$i<$arrlen; $i++){
         
        $forumPost = $forumposts[$i];
        $forumPostID = $forumpostids[$i];    
        $forumPostDate = $forumpostdates[$i];
        $forumStudentID = $forumpoststudentids[$i];
        $forumParentPostID = $forumparentpostids[$i];
        
        $sql_query_forum_post_studentID = "SELECT * FROM USER WHERE StudentID=" . $forumStudentID . "";
        $result_forum_post_studentID = mysqli_query($db, $sql_query_forum_post_studentID) or die('query failed'. mysqli_error($db));
        $row5 = mysqli_fetch_assoc($result_forum_post_studentID);
        $username_forum_post = $row5['Username'];
        mysqli_free_result($result_forum_post_studentID);
        
        if($forumParentPostID == 0){
        
            echo "<a href=\"profilePage.php?id=".$forumStudentID."\">" . $username_forum_post . "</a>:<br/>";
			echo "<p>";
			echo $forumPost;
			echo "</p>";
            echo "<button>";
            echo "<a href=\"replyForumPostPage.php?id=".$forumPostID."&tid=".$forumTopicID."\">Reply</a><br/>";
            echo "</button>";
			//echo "<hr>";
            
            if ($forumPostID == $forumReplyParentPostID) {
        ?>
            
            <form method="post" <?php echo 'action="replyForumPostPage.php?id='.$forumReplyParentPostID.'&tid='.$forumTopicID.'"' ?> >
                
                <div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:center;width:calc(60% + 8px);word-wrap:break-word;">
                    <h2 style="text-align:center;padding-top:8px;">Reply</h2>
                    <input type="hidden" name="studentId" value='<?php echo $_SESSION['id'];?>' />
                    <input type="hidden" name="forumTopicId" value='<?php echo $forumTopicID;?>' />
                    <input type="hidden" name="forumParentPostId" value='<?php echo $forumReplyParentPostID;?>' />
                    <div class="commentDiv" style="text-align:center;">
                        <textarea class="formInputField" style="text-align:center;" name="commentField" rows="4" cols="50" placeholder="Enter comment here..."></textarea>
                        <br/>
                        <button type="submit" id="commentSubmit" class="formSubmit formBtn" style="margin-top:5px;border:1px solid black;" name="comment_posted">Submit</button>
                    </div> 
                </div>
            </form> 
        <br/>
        <hr>
            
 <?php                        
         include('errors.php');
        }else{
            echo "<hr>"; 
        }


            
            //Get all child posts related to forum topic
            $sql_query_child_forum_post = "SELECT * FROM FORUM_POSTS WHERE ForumParentPostID=" . $forumPostID . " ORDER BY FORUM_POSTS.ForumPostDate";
            $result_child_forum_post = mysqli_query($db, $sql_query_child_forum_post) or die('query failed'. mysqli_error($db));
            
            $forumchildpostids=array();
            $forumchildposts=array();
            $forumchildpostdates=array();
            $forumchildpoststudentids=array();
            
            if($result_child_forum_post->num_rows > 0){
                while($row6 = $result_child_forum_post->fetch_assoc()){
                    array_push($forumchildpostids, $row6['ForumPostID']);
                    array_push($forumchildposts, $row6['ForumPost']);
                    array_push($forumchildpostdates, $row6['ForumPostDate']);
                    array_push($forumchildpoststudentids, $row6['StudentID']);
                }
            }    

            $numPosts2 = $result_child_forum_post->num_rows;
            
            for($j=0;$j<$numPosts2; $j++){
                $forumChildPost = $forumchildposts[$j];
                $forumChildPostID = $forumchildpostids[$j];    
                $forumChildPostDate = $forumchildpostdates[$j];
                $forumChildStudentID = $forumchildpoststudentids[$j];
                $forumChildParentPostID = $forumchildparentpostids[$j];
                
                $sql_query_forum_child_post_studentID = "SELECT * FROM USER WHERE StudentID=" . $forumChildStudentID . "";
                $result_forum_child_post_studentID = mysqli_query($db, $sql_query_forum_child_post_studentID) or die('query failed'. mysqli_error($db));
                $row7 = mysqli_fetch_assoc($result_forum_child_post_studentID);
                $username_child_forum_post = $row7['Username'];
                
                echo "<a href=\"profilePage.php?id=".$forumChildStudentID."\">" . $username_child_forum_post . "</a>:<br/>";
                echo "<p>";
                echo $forumChildPost;
                echo "</p>";
                echo "<hr>";    
                
                mysqli_free_result($result_forum_child_post_studentID);
                mysqli_free_result($result_child_forum_post);
            }
            
        }else{

        }
    }
    
    if($arrlen == 0){
             echo 'No Posts have been created yet!';
    }
    
    mysqli_close($db);
    
    ?>
 
    </div>

<br/>
<br/>

<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>
    
</body>
</html>