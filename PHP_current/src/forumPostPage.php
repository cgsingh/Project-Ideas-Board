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

// for now, instead of making visitor login, allow them to view projects (makes view count more meaningful)
/*
if ($_SESSION['id']=="") { 
    header('location: loginPage.php');
}*/


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
	<style>
		.replys {
			text-align: left;
			padding-left: 10px;
			padding-right: 10px;
			margin-top: 3px;
			border-left: solid 1px #444444;
		}
		
		.root-reply {
			text-align: left;
			padding-left: 10px;
			padding-right: 10px;
			margin-top: 3px;
		}
		
		.replyButton {
			background-color: #6f87b9;
			color: #FFFFFF;
			border: 1px solid black;
			padding: 4px;
		}
		
	</style>
	
    </head>

<body>
	<?php include('navigationBar.php'); ?>
	
    <?php
    
    $forumTopicID = $_GET["id"];
    
    //Get all Forum Topic Information
    $sql_query_forum_topic = "SELECT * FROM FORUM_TOPICS WHERE ForumTopicID=" . $forumTopicID . "";
    $result_forum_topic = mysqli_query($db, $sql_query_forum_topic) or die('topic query failed'. mysqli_error($db));
    $row = mysqli_fetch_assoc($result_forum_topic);
    $forumCategoryID = $row['ForumCategoryID'];
    $forumTopicStudentID = $row['StudentID'];
    $forumTopicDate = $row['ForumTopicDate'];
    $forumTopicDescription = $row['ForumTopicDescription'];
    $forumTopicTitle = $row['ForumTopicTitle'];
    $forumTopicActive = $row['ActiveForumTopic'];
    mysqli_free_result($result_forum_topic);
    
    //Get the Name of the Forum Category
    $sql_query_forum_category = "SELECT * FROM FORUM_CATEGORIES WHERE ForumCategoryID=" . $forumCategoryID . "";
    $result_forum_category = mysqli_query($db, $sql_query_forum_category) or die('category query failed'. mysqli_error($db));
    $row2 = mysqli_fetch_assoc($result_forum_category);
    $forumCategory = $row2['ForumCategory'];
    mysqli_free_result($result_forum_category);
    

    //Get the name of the student related to the topic
    $sql_query_forum_topic_studentID = "SELECT * FROM USER WHERE StudentID=" . $forumTopicStudentID . "";
    $result_forum_topic_studentID = mysqli_query($db, $sql_query_forum_topic_studentID) or die('student query failed'. mysqli_error($db));
    $row4 = mysqli_fetch_assoc($result_forum_topic_studentID);
    $username_forum_topic = $row4['Username'];
    mysqli_free_result($result_forum_topic_studentID);
    
    
    //COMMENT POSTED
 
    ?>
	

	
	<div style="margin-top:50px;width:60%;padding-left:8px;padding-top:8px;padding-bottom:8px;text-align:left;background-color:#758ab6;margin-left:66px;color:black;">
	<?php
        echo '<h2 style="margin-top:-5px;text-align:center;">' . $forumTopicTitle . '</h2>';
        echo '<p style="margin-top:-6px;text-align:center;">Topic created by <a style="text-decoration:none;" href="profilePage.php?id=' . $forumTopicStudentID . '">@' . $username_forum_topic . '</a> on ';
        $date = date_create($forumTopicDate);
        echo date_format($date, "F j, Y") . '</p>';
        echo '<p class="projectIntro" style="margin-left:0px;text-align:center;">' . $forumTopicDescription . '</p><br/>';
            
        echo 'Posts <span style="color:black;font-weight:bold;background-color:green;border-radius:50%;padding:6px;padding-left:11px;padding-right:11px;">' . $numPosts . '</span>';    
        
        if($forumTopicActive==1){
            echo " Topic is open";
        }
        
        if($forumTopicActive==0){
            echo " Topic is Closed";
        }
        
    ?>
        
    </div>
    
    <?php
	
	if ($_POST['comment_posted']){
		echo "blah blah ";
        include('commentForumPost.php');
    }
    
	
    if ($_SESSION['id']) {?>
        <form method="post" <?php echo 'action="forumPostPage.php?id=' . $_GET["id"] . '"' ?>>
            <div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:center;width:calc(60% + 8px);word-wrap:break-word;">
                <h2 style="text-align:center;padding-top:8px;">Posts</h2>
                <input type="hidden" name="studentId" <?php if($forumTopicActive == 0){echo "disabled";}?> value='<?php echo $_SESSION['id'];?>' />
                <input type="hidden" name="forumTopicId" <?php if($forumTopicActive == 0){echo "disabled";}?> value='<?php echo $forumTopicID;?>' />
                <div class="commentDiv" style="text-align:center;">
                    <textarea class="formInputField" style="text-align:center;" name="commentField" rows="4" cols="50" placeholder="Enter comment here..." <?php if($forumTopicActive == 0){echo "disabled";} ?>> </textarea>
                    <br/>
                    <input type="submit" id="commentSubmit" class="formSubmit formBtn" style="margin-top:5px;border:1px solid black;" name="comment_posted" value="Submit" <?php if($forumTopicActive == 0){echo"disabled";}?> />
                </div> 
            </div>
        </form> 
            
 <?php  
                          
         include('errors.php');
    }else{
?>
                
                <form method="post" 'action="forumPostPage.php"'>
                    <div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:center;width:calc(60% + 8px);word-wrap:break-word;">
                        <h2 style="text-align:center;padding-top:8px;">Comments</h2>
                        <input type="hidden" name="studentId" disabled />
                        <input type="hidden" name="forumTopicId" disabled />
                        <div class="commentDiv" style="text-align:center;">
                            <textarea class="formInputField" style="text-align:center;" name="commentField" rows="4" cols="50" placeholder="Login to make comments." disabled></textarea>
                            <br/>
                        <button type="submit" id="commentSubmit" class="formSubmit formBtn"  style="margin-top:5px;border:1px solid black;" name="comment_posted" disabled>Submit</button>
                        </div>
                    </div>
                </form>
<?php } ?>

<br/>
    
    <div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:left;width:calc(60% + 8px);word-wrap:break-word;">

<?php

    
    if ($_POST['replySubmit']){
        include('createReplyForumPost.php');
    }
	if ($_POST['replyDelete']){
        include('deleteForumComment.php');
    }
    
    $db = new mysqli($servername, $username, $password, $dbname);
	
	function appendReplys($replyId, $_db) {
	$replyQuery = 'SELECT FORUM_POSTS.ForumPostID, FORUM_POSTS.ForumPost, FORUM_POSTS.studentID, USER.username FROM FORUM_POSTS LEFT JOIN USER ON FORUM_POSTS.StudentID = USER.StudentID
		WHERE FORUM_POSTS.ForumTopicID ="' . $_GET["id"] . '" AND FORUM_POSTS.ForumParentPostID = "' . $replyId . '" ORDER BY FORUM_POSTS.ForumPostDate DESC;';
		
	$replys = mysqli_query($_db, $replyQuery) or die('reply query failed'. mysqli_error($_db));
		
		if ($replys->num_rows > 0) {
			while($row = $replys->fetch_assoc()){
				echo "<div class='replys'><br/>";
				if ($row["studentID"] != NULL) {			
					echo "<a href=\"profilePage.php?id=".$row["studentID"]."\">" . $row["username"] . "</a>:<br/>";
					echo "<p>";
					echo $row["ForumPost"];
					if ($row["studentID"] == $_SESSION['id']) {				
						echo "<form method='POST' action='forumPostPage.php?id=" . $_GET['id'] . "'>";
						echo "<input type='hidden' name='projectID' value='" . $_GET["id"] . "' />";
						echo "<input type='hidden' name='forumPostId' value='" . $row["ForumPostID"] . "'/>";
						echo "<input type='submit' id='replyDelete' name='replyDelete' value='Delete?'/></form>";
					}
					echo "</p>";

					echo "<form method='POST' action='forumPostPage.php?id=" . $_GET['id'] . "'>";
					echo "<textarea id='replyText' name='commentField' class='formInputField' style='text-align:center;' rows='2' cols='50' placeholder='Enter comment here...'></textarea>";
					echo "<input type='hidden' name='studentId' value='" . $_SESSION['id'] . "' />";
					echo "<input type='hidden' name='projectId' value='" . $_GET["id"] . "' />";
					echo "<input type='hidden' name='replyId' value='" . $row["ForumPostID"] . "'/>";
					echo "<br/><input type='submit' id='replySubmit' name='replySubmit'/></form>";
				} else {
					echo $row["username"];
					echo "<span style='color:#333333'><i>~~ Removed ~~<br/>";
					echo "<p>Comment Deleted.</p></i></span>";
				}
				
				appendReplys($row["ForumPostID"], $_db);	
				echo "</div>";
			}
		}
		
	}
	
    $sql_query = 'SELECT FORUM_POSTS.ForumPostID, FORUM_POSTS.ForumPost, FORUM_POSTS.studentID, USER.username FROM FORUM_POSTS LEFT JOIN USER ON FORUM_POSTS.StudentID = USER.StudentID
		WHERE FORUM_POSTS.ForumTopicID ="' . $_GET["id"] . '" AND FORUM_POSTS.ForumParentPostID = 0 ORDER BY FORUM_POSTS.ForumPostDate DESC;';
    $result2 = mysqli_query($db, $sql_query) or die('root query failed '. mysqli_error($db));
    
    if ($result2->num_rows > 0) {
		echo "<hr>";
        while($row = $result2->fetch_assoc()){
			
			echo "<div class='root-reply'>";
			
			if ($row["studentID"] != NULL) {			
				echo "<a href=\"profilePage.php?id=".$row["studentID"]."\">" . $row["username"] . "</a>:<br/>";
				echo "<p>";
				echo $row["ForumPost"];
				if ($row["studentID"] == $_SESSION['id']) {				
					echo "<form method='POST' action='forumPostPage.php?id=" . $_GET['id'] . "'>";
					echo "<input type='hidden' name='projectID' value='" . $_GET["id"] . "' />";
					echo "<input type='hidden' name='forumPostId' value='" . $row["ForumPostID"] . "'/>";
					echo "<input type='submit' id='replyDelete' name='replyDelete' value='Delete?'/></form>";
				}
				echo "</p>";

				echo "<form method='POST' action='forumPostPage.php?id=" . $_GET['id'] . "'>";
				echo "<textarea id='replyText' name='commentField' class='formInputField' style='text-align:center;' rows='2' cols='50' placeholder='Enter comment here...'></textarea>";
				echo "<input type='hidden' name='studentId' value='" . $_SESSION['id'] . "' />";
				echo "<input type='hidden' name='projectId' value='" . $_GET["id"] . "' />";
				echo "<input type='hidden' name='replyId' value='" . $row["ForumPostID"] . "'/>";
				//echo "<input type='hidden' name='notificationId' value='" . $row["studentID"] . "'/>";
				echo "<br/><input type='submit' id='replySubmit' name='replySubmit'/></form>";
			} else {
				echo $row["studentID"];
				echo "<span style='color:#333333'><i>~~ Removed ~~<br/>";
				echo "<p>Comment Deleted.</p></i></span>";
			}
			
			appendReplys($row["ForumPostID"], $db);	
			echo "</div>";
			echo "<hr>";
			
		}
    }else{
        echo 'No Posts have been created yet!';
    }
	
	
    /*
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
            
            if($forumTopicActive == 1){
                echo "<button>";
                echo "<a href=\"replyForumPostPage.php?id=".$forumPostID."&tid=".$forumTopicID."\">Reply</a><br/>";
                echo "</button>";
            }
			echo "<hr>";
            
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
    }*/
    
    
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