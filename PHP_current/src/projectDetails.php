<?php

/*
Group: 22
BTS530
File: projectDetails.php
*/

include('projDetails.php');

if ($_POST['commentField'])
{
include('commentPost.php');
}

if ($_POST['replyDelete']) {
include('deleteComment.php');
}
 
session_start();

// for now, instead of making visitor login, allow them to view projects (makes view count more meaningful)
/*
if ($_SESSION['id']=="") { 
    header('location: loginPage.php');
}*/

//make array containing the list of all projects viewed (prevent multiple views per session)
//this isn't full-proof, but avoids having to create a table in db to permanently store this info
if ($_SESSION['ViewedProjects']=="")
{
	$_SESSION['ViewedProjects'] = array();
}

//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

    $errorMessage = ""; 
    
//connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);


    //NEWLY ADDED CODE: JAN 10, 2020
    $group_id="";
    $proj_id="";
    $requestids=array();
    $unames=$uid=array();
    $sess =  $_SESSION['id'];
    $studentid = "";
    $filePath = "uploadedFiles/";
    $fileName="";
    $actFileName="";
    $file=0;
    
    //------------------------------
    
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
    
    $projectID = $_GET["id"];
    
    $sql_query = "SELECT PROJECT.StudentID, PROJECT.Title, PROJECT.Details, PROJECT.Tags, PROJECT.DateCreated, PROJECT.Likes, PROJECT.Dislikes, PROJECT.Views, PROJECT.file, USER.Username FROM PROJECT INNER JOIN USER ON PROJECT.StudentID=USER.StudentID WHERE PROJECT.ProjectID='" . $projectID . "'";
    
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $likes = 0;
    $dislikes = 0;
    
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
			$projectownerid = $row['StudentID'];
            $likes = $row['Likes'];
            $dislikes = $row['Dislikes'];
			$usernameP = $row['Username'];
            $datecreatedP = $row["DateCreated"];
            $titleP = $row["Title"];
            $detailsP = $row["Details"];
            $tagsP = $row['Tags'];
            $viewsP = $row['Views'];
            $file = $row['file'];
            //$fileName = $row['fileSaveName'];
            //$actFileName = $row['actFileName'];
        }
		
		?>
	
	<div style="margin-top:42px;position:fixed;left:8px;top:8px;">
<form method="post" <?php echo 'action="projectDetails.php?id=' . $_GET["id"] . '"' ?>>
<button class="btnld" style="width:50px;height:65px;text-align:center;margin-bottom:2px;font-size:20px;border: 1px solid green;" name="btnLike" <?php if (!$_SESSION['id']){ echo 'disabled';    } ?> >
<i class="like"></i>
&#128077;
<span class="projTitle" style="vertical-align:middle;text-align:center;color:green;"><?php echo $likes;?></span>
</button><br/>
<button class="btnld"  style="width:50px;height:65px;text-align:center;font-size:20px;border: 1px solid red;" name="btnDislike" <?php if (!$_SESSION['id']){ echo 'disabled';    } ?> >
<span class="projTitle" style="vertical-align:middle;text-align:center;color:red;"><?php echo $dislikes;?></span>
<i class="dislike"></i>
&#128078;
</button>
</form>
</div>
	
	<div style="margin-top:50px;width:60%;padding-left:8px;padding-top:8px;padding-bottom:8px;text-align:left;background-color:#758ab6;margin-left:66px;color:black;">
	<?php
            echo '<h2 style="margin-top:-5px;text-align:center;">' . $titleP . '</h2>';
			echo '<p style="margin-top:-6px;text-align:center;">Submitted by <a style="text-decoration:none;" href="profilePage.php?id=' . $projectownerid . '">@' . $usernameP . '</a> on ';
            $date = date_create($datecreatedP);
            echo date_format($date, "F j, Y") . '</p>';
            echo '<p class="projectIntro" style="margin-left:0px;text-align:center;">' . $detailsP . '</p><br/>';
            echo '<p class="projLikes" style="margin-left:0px;text-align:center;">' . $tagsP . '</p><br/>';
            //echo '<p class="projLikes" style="margin-left:0px;">Views: ' . $viewsP . '</p>';
			
			echo '<p style="text-align:center;">Views <span style="color:black;font-weight:bold;background-color:green;border-radius:50%;padding:6px;padding-left:11px;padding-right:11px;margin-right:10px;">' . $viewsP . '</span>';
			
			$sql_query = "SELECT * FROM COMMENTS WHERE ProjectID = " . $projectID;

			$resultPosts = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $numPosts = $resultPosts->num_rows;
			
			echo 'Comments <span style="color:black;font-weight:bold;background-color:green;border-radius:50%;padding:6px;padding-left:11px;padding-right:11px;">' . $numPosts . '</span>';
            //$fileName = $row['fileSaveName'];
            //$actFileName = $row['actFileName'];
        
        //if this project id does not exist in the viewed projects array in this session, add it, and increment view count
        
        if (!in_array($projectID, $_SESSION['ViewedProjects'])){
            
            //increment the view count
            $sql_query = "UPDATE PROJECT SET Views = Views + 1 WHERE PROJECT.ProjectID='" . $projectID . "'";
            $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            array_push($_SESSION['ViewedProjects'], $projectID);
        }
    }else{
        echo 'error';
    }
    
    mysqli_free_result($result);
    
    ?>
</div>

<div class="requests" style="background-color: #3b5998;margin-left:8px;margin-top:42px;width:calc(100% - 60% - 90px);text-align:center;position:fixed;right:8px;top:8px;color:white;">
<h2 style="text-align:center;">Files</h2>
<?php
				
				
    $fNames= array();
    $actFNames= array();
    
    
    if($file != 0){?>
<?php
    
    $sql_query = "SELECT fileSaveName, actSaveName FROM FILES WHERE ProjectID ='".$projectID."';";
    $result =  mysqli_query($db, $sql_query) or die('query select from files has failed'. mysqli_error($db));
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            
            array_push($fNames,$row['fileSaveName']);
            array_push($actFNames, $row['actSaveName']);
        }
    }
    
    $imgsArr = array("jpeg", "jpg", "png");
    $docsArr = array("pdf", "docx", "txt", "zip");
    
    for($i =0; $i< count($fNames); $i++){
        //check if image
        if(in_array(pathinfo($fNames[$i] ,PATHINFO_EXTENSION), $imgsArr)){
            $fullPath = $filePath;
            $fullPath.=$fNames[$i];
            ?>
<div class="zoomin" style="text-align:center;"><img style="width:100px;height:100px;" src= "<?php echo $fullPath;?>" alt= "<?php echo $actFNames[$i]?>" ></div>
<p align="center">Download: <a href="<?php echo $fullPath;?>" download target="_blank"><?php echo $actFNames[$i];?></a></p>
<?php
}
    //check if document
    if(in_array(pathinfo($fNames[$i] ,PATHINFO_EXTENSION), $docsArr)){
								$fullPath = $filePath;
								$fullPath.=$fNames[$i];
								?>
<a href="<?php echo $fullPath;?>" target="_blank">View <?php echo $actFNames[$i];?></a>
<a href="<?php echo $fullPath;?>" download target="_blank">Download: <?php echo $actFNames[$i];?></a>
<?php
    }
    }
				?>
<?php
    }
	else
	{
		echo "<p>No files available.</p>";
	}
    ?>

<?php include('errors.php'); ?>
<hr>
<h2 style="text-align:center;">Requests</h2>

<?php
    
    $sql_query = "SELECT StudentID, ProjectID FROM PROJECT WHERE ProjectID ='" . $projectID . "'";
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    
    $sql_query2 = "SELECT GroupID
    FROM GROUP_LIST WHERE ProjectID = '" . $projectID  . "'";
    $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
    
    $row = mysqli_fetch_assoc($result);
    $row2 = mysqli_fetch_assoc($result2);
    
    $stu_id = $row['StudentID'];
    $proj_id = $row['ProjectID'];
    $group_id = $row2['GroupID'];
    
    mysqli_free_result($result);
    mysqli_free_result($result2);
    
    if ($sess == $stu_id){
        
        $sql_query = "SELECT UserID FROM REQUESTS WHERE PROJECTID ='" . $proj_id . "'";
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($uid, $row['UserID']);
                array_push($requestids, $row['UserID']);
            }
            
            $arrlen=count($uid);
            
            for( $i=0; $i<$arrlen; $i++){
                $sql_query2 = "SELECT USER.Username from USER
                Left Join REQUESTS
                ON USER.StudentID = REQUESTS.UserID
                WHERE USER.StudentID ='" .$uid[$i]. "' AND
                REQUESTS.PROJECTID ='" .$proj_id . "'";
                
                $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
                
                if($result->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                        array_push($unames, $row2['Username']);
                    }
                }
            }
            
            for($i=0;$i<sizeof($unames); $i++){
                $acc = "acc".$i;
                $den = "den".$i;
                $user= $unames[$i];
                $userIDs = $uid[$i];
                $userrequest= $requestids[$i];
                
                //echo $user . " has requested to join.   ";
                
                echo "<a href=\"profilePage.php?id=". $userIDs ."\">" . $user;
                echo "</a>";
                echo " has requested to join.   ";
                echo "<button type='submit' style='padding: 10px;'>";
                echo "<a style='text-decoration:none;' href='acceptRequest.php?id=" .  $userrequest . "&proj=" . $proj_id . "&group=" . $group_id . "'>";
                echo "&#9989";
                echo "</a>";
                echo "</button>";
                echo "<button type='submit' style='padding: 10px;'>";
                echo "<a style='text-decoration:none;' href='deleteRequest.php?id=" .  $userrequest . "&proj=" . $proj_id . "&group=" . $group_id . "'>";
                echo "&#10060";
                echo "</a>";
                echo "</button>";
                echo "</br>";
                mysqli_free_result($result);
                mysqli_free_result($result2);
            }
        }else{
            echo "<p>No one has requested to join.</p>";
        }
    }else{
        
        if ($_SESSION['id']) {
            
            $err="You are already a part of this group.";
            $err2="Request is already sent.";
            $reqstd="Successfully Requested.";
            $requestValid = false;
            
            $sql_query = "SELECT * FROM GROUP_MEMBERS WHERE StudentID ='" . $_SESSION['id'] . "' AND GroupID ='" . $group_id . "'";
            $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            
            if($result->num_rows > 0){
                echo "<p>" . $err . "</p>";
            }else{
                
                echo "<div style='text-align:center;'><form method='Post'>";
                echo "<input class='formBtn' type='submit' name='rqstJoin' value='Request To Join'/>";
                echo "</form></div>";
                
                
                
                if(isset($_POST['rqstJoin'])){
                    
                    $sql_query = "SELECT * FROM REQUESTS WHERE USERID ='" . $_SESSION['id'] . "' AND PROJECTID ='" . $proj_id . "'";
                    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                    
                    if($result->num_rows > 0){
                        echo "<p>" . $err2 . "</p>";
                    }else{
                        $sql = "INSERT INTO REQUESTS(UserID, ProjectID) VALUES('".$sess."','".$proj_id."')";
                        
                        if($db->query($sql) === TRUE){
                            echo "<p>" . $reqstd . "</p>";
                            
                            $sql_query3 = 'SELECT * FROM PROJECT WHERE ProjectID="'. $projectID. '"LIMIT 1';
                            $result3 = mysqli_query($db, $sql_query3) or die('query failed'. mysqli_error($db));
                            $row = mysqli_fetch_assoc($result3);
                            $projectUserID = $row['StudentID'];
                            $projectName = $row['Title'];
                            mysqli_free_result($result3);
                            
                            
                            $notificationMessage1 = "You have sent a request to join this group: " . $projectName . "";
                            $notificationMessage2 = "You have a group request for this project: " . $projectName . "";
                            
                            $sql_insert1 = 'INSERT INTO NOTIFICATIONS set NotificationID=NULL, 
                            StudentID="' . $_SESSION['id'] . '", 
                            Notification="' . $notificationMessage1 . '",
                            ProjectID="' . $proj_id .'"';
                            
                            //Run our sql insert statement
                            $resultInsert1 = mysqli_query($db,  $sql_insert1)or die('query failed'. mysqli_error($db));;
                            mysqli_free_result($resultInsert1);

                            $sql_insert2 = 'INSERT INTO NOTIFICATIONS set NotificationID=NULL, 
                            StudentID="' . $projectUserID . '", 
                            Notification="' . $notificationMessage2 . '",
                            ProjectID="' . $proj_id .'"';

                            //Run our sql insert statement
                            $resultInsert2 = mysqli_query($db,  $sql_insert2)or die('query failed'. mysqli_error($db));;
                            mysqli_free_result($resultInsert2);     
                            
                        }
                    }
                }
            }
        }else{
            echo "<p>You must be logged in to join this group.</p>";
        }
    }
    ?>
<hr>	
	
<h2 style="text-align:center;">Group Member(s)</h2>
<!--<ol class="groupSection" id="groupList" style="list-style-type:none;">-->

<?php
    //$sql_query = "SELECT * FROM GROUP_MEMBERS WHERE GroupID ='" . $group_id . "'";
    $sql_query = "SELECT * FROM GROUP_MEMBERS WHERE GroupID ='" . $group_id . "'";
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    
    if ($result->num_rows > 0) {
		echo '<div style="text-align:center;">';
        while($row = $result->fetch_assoc()) {
            echo "<p><a style='color:white;'href='profilePage.php?id=" . $row["StudentID"] . "'>";
            $sql_query2 = "SELECT * FROM USER WHERE StudentID ='" . $row['StudentID'] . "'";
            $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
            $row3 = mysqli_fetch_assoc($result2);
            echo $row3['Username'];
            echo "</a><p>";
            mysqli_free_result($result2);
        }
		echo "</div>";
    }
	else
	{
		echo '<div style="text-align:center;">';
		echo "<p>No members yet.</p>";
		echo '</div>';
	}
    
    /*------------------------------------------------------------------------------------------------------------
     */
    ?>
</ol>
</div>


<!-- ---------------------------------------------------------------------------------------------- -->
<?php
    if ($_SESSION['id']) {?>
<form method="post" <?php echo 'action="projectDetails.php?id=' . $_GET["id"] . '"' ?>>
<div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:center;width:calc(60% + 8px);word-wrap:break-word;">
<h2 style="text-align:center;padding-top:8px;">Comments</h2>
<input type="hidden" name="studentId" value='<?php echo $_SESSION['id'];?>' />
<input type="hidden" name="projectId" value='<?php echo $_GET["id"];?>' />
<input type='hidden' name='replyId' value='x'/>
<input type='hidden' name='notificationId' value='<?php echo $projectownerid; ?>'/>
<div class="commentDiv" style="text-align:center;">
<textarea class="formInputField" style="text-align:center;" name="commentField" rows="4" cols="50" placeholder="Enter comment here..."></textarea>
<br/>
<button type="submit" id="commentSubmit" class="formSubmit formBtn" style="margin-top:5px;border:1px solid black;" name="comment_posted">Submit</button>
</div>
</form>
<?php include('errors.php');
    }else{
        ?>
<form method="post" <?php echo 'action="projectDetails.php?id=' . $_GET["id"] . '"' ?>>
<div class="requests" style="background-color:#758ab6;margin-left:66px;margin-top:-14px;text-align:center;width:calc(60% + 8px);word-wrap:break-word;">
<h2 style="text-align:center;padding-top:8px;">Comments</h2>
<input type="hidden" name="studentId" disabled />
<input type="hidden" name="projectId" disabled />
<div class="commentDiv" style="text-align:center;">
<textarea class="formInputField" style="text-align:center;" name="commentField" rows="4" cols="50" placeholder="Login to make comments." disabled></textarea>
<br/>
<button type="submit" id="commentSubmit" class="formSubmit formBtn"  style="margin-top:5px;border:1px solid black;" name="comment_posted" disabled>Submit</button>
</div>
</form>
<?php } ?>

<br/>

<?php
	function appendReplys($replyId, $_db) {
		$replyQuery = 'SELECT COMMENTS.commentID, COMMENTS.comment, COMMENTS.studentID, USER.username FROM COMMENTS LEFT JOIN USER ON COMMENTS.StudentID = USER.StudentID
			WHERE COMMENTS.ProjectID ="' . $_GET["id"] . '" AND COMMENTS.ReplyId = "' . $replyId . '" ORDER BY COMMENTS.CommentDate DESC;';
			
		$replys = mysqli_query($_db, $replyQuery) or die('reply query failed'. mysqli_error($_db));
		
		if ($replys->num_rows > 0) {
			while($row = $replys->fetch_assoc()){
				echo "<div class='replys'><br/>";
				if ($row["studentID"] != NULL) {			
					echo "<a href=\"profilePage.php?id=".$row["studentID"]."\">" . $row["username"] . "</a>:<br/>";
					echo "<p>";
					echo $row["comment"];
					if ($row["studentID"] == $_SESSION['id']) {				
						echo "<form method='POST' action='projectDetails.php?id=" . $_GET['id'] . "'>";
						echo "<input type='hidden' name='projectID' value='" . $_GET["id"] . "' />";
						echo "<input type='hidden' name='commentID' value='" . $row["commentID"] . "'/>";
						echo "<input type='submit' id='replyDelete' name='replyDelete' value='Delete?'/></form>";
					}
					echo "</p>";

					echo "<form method='POST' action='projectDetails.php?id=" . $_GET['id'] . "'>";
					echo "<textarea id='replyText' name='commentField' class='formInputField' style='text-align:center;' rows='4' cols='50' placeholder='Enter comment here...'></textarea>";
					echo "<input type='hidden' name='studentId' value='" . $_SESSION['id'] . "' />";
					echo "<input type='hidden' name='projectId' value='" . $_GET["id"] . "' />";
					echo "<input type='hidden' name='replyId' value='" . $row["commentID"] . "'/>";
					echo "<input type='hidden' name='notificationId' value='" . $row["studentID"] . "'/>";
					echo "<br/><input type='submit' id='replySubmit' name='replySubmit'/></form>";
				} else {
					echo "<span style='color:#333333'><i>~~ Removed ~~<br/>";
					echo "<p>Comment Deleted.</p></i></span>";
				}
				
				appendReplys($row["commentID"], $_db);	
				echo "</div>";
			}
		}
		
	}
	
	
    $sql_query = 'SELECT COMMENTS.commentID, COMMENTS.comment, COMMENTS.studentID, USER.username FROM COMMENTS LEFT JOIN USER ON COMMENTS.StudentID = USER.StudentID
		WHERE COMMENTS.ProjectID ="' . $_GET["id"] . '" AND ISNULL(COMMENTS.ReplyID) ORDER BY COMMENTS.CommentDate DESC';
    $result2 = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    
    if ($result2->num_rows > 0) {
		echo "<hr>";
        while($row = $result2->fetch_assoc()){
			
			echo "<div class='root-reply'>";
			
			if ($row["studentID"] != NULL) {			
				echo "<a href=\"profilePage.php?id=".$row["studentID"]."\">" . $row["username"] . "</a>:<br/>";
				echo "<p>";
				echo $row["comment"];
				if ($row["studentID"] == $_SESSION['id']) {				
					echo "<form method='POST' action='projectDetails.php?id=" . $_GET['id'] . "'>";
					echo "<input type='hidden' name='projectID' value='" . $_GET["id"] . "' />";
					echo "<input type='hidden' name='commentID' value='" . $row["commentID"] . "'/>";
					echo "<input type='submit' id='replyDelete' name='replyDelete' value='Delete?'/></form>";
				}
				echo "</p>";

				echo "<form method='POST' action='projectDetails.php?id=" . $_GET['id'] . "'>";
				echo "<textarea id='replyText' name='commentField' class='formInputField' style='text-align:center;' rows='4' cols='50' placeholder='Enter comment here...'></textarea>";
				echo "<input type='hidden' name='studentId' value='" . $_SESSION['id'] . "' />";
				echo "<input type='hidden' name='projectId' value='" . $_GET["id"] . "' />";
				echo "<input type='hidden' name='replyId' value='" . $row["commentID"] . "'/>";
				echo "<input type='hidden' name='notificationId' value='" . $row["studentID"] . "'/>";
				echo "<br/><input type='submit' id='replySubmit' name='replySubmit'/></form>";
			} else {
				echo "<span style='color:#333333'><i>~~ Removed ~~<br/>";
				echo "<p>Comment Deleted.</p></i></span>";
			}
			
			
			appendReplys($row["commentID"], $db);
			
			echo "</div>";
			echo "<hr>";
			
		}
    }else{
        
    }
    
    mysqli_free_result($result2);
    mysqli_close($db);
    
    ?>
</div>
</div>
<br/>
<br/>

<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>
</body>
	
	<script type="text/javascript">
		
	function reply(id) {
		var x = "<form method='POST' " + <?php echo "action='projectDetails.php?id=" . $_GET['id'] . "'>" ?>;
		x += "<textarea id='replyText' name='replyField' class='formInputField' style='text-align:center;' rows='4' cols='50' placeholder='Enter comment here...'></textarea>";
		x += "<br/><input type='submit' id='replySubmit' class='formSubmit formBtn' style='margin-top:5px;border:1px solid black;'/>";
		x += "<input type='hidden' name='replyId' value='" + id + "'/>"
		x += "<button class='formSubmit formBtn' style='margin-top:5px;border:1px solid black;' onclick='cancelReply(" + id + ");'>Cancel</button></form>";
		document.getElementById("replyArea" + id).innerHtml = x;
		
	}
	
	function cancelReply(id) {/*
		document.getElementById("replyArea" + id).innerHtml = "<button onclick='reply(" + id + ");'>Reply</button>";*/
		
	}
	
	</script>
</html>
