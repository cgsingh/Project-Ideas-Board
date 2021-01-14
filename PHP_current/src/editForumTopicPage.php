<?php

/*
Group: 22
BTS530
File: editForumTopicPage.php
*/
//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

session_start();

include ('sessionCheck.php');
if (!checkSession()) {
	header("location: loginRequired.php");
}
$errors = array();

$valid = false;

//Get Forum Category based on ID
$forumTopicID = $_GET["id"];


    if ($_POST)
    {
        if ($_SESSION['id'])
        {
			//Test for nothing entered in field
            if ($_POST['forumTitle'] == "") {
                array_push($errors, "Title is required");
                $valid = false;
            }else{
                
                $valid = true;
            }
			
			if ($_POST['forumDescription'] == "") {
                array_push($errors, "Description is required");
                $valid = false;
            }else{
                
                $valid = true;
            }
			
			if ($valid)
			{
					$sql_query = "UPDATE FORUM_TOPICS SET ForumTopicDescription='".$_POST['forumDescription']."', 
                    ForumTopicTitle='".$_POST['forumTitle']."' WHERE StudentID='".$_SESSION['id']."' AND ForumTopicID='" . $forumTopicID . "'";
					
					$result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));;
					mysqli_free_result($result);
					
					mysqli_close($db);
                    header("location: forumPostPage.php?id=".$forumTopicID."");
			}
			else
			{
				echo '<script language="javascript">';
				echo 'alert("All Fields Required.")';
				echo '</script>';
			}
        }
        else
        {
            mysqli_close($db);
            header('location: forumPage.php');
        }
        
        
    }else{
        $sql_query = "SELECT * FROM FORUM_TOPICS WHERE StudentID='" . $_SESSION['id'] . "' AND ForumTopicID='" . $forumTopicID . "'";					
		$result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));
        $row = mysqli_fetch_assoc($result);
        
        $topicTitle = $row['ForumTopicTitle'];
        $topicDesc = $row['ForumTopicDescription'];
    }
    ?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/register.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		<div class="formContainer" style="margin-top: 15px;">
            
			<form class="formStyle" action="editForumTopicPage.php?id=<?php echo $_GET['id']; ?>" method="post">
                <h2 class="formTitle">Create Forum Topic</h2>
			
                <p class="formText">Topic Title:</p>
                <input type="text" class="formInputField" name="forumTitle" maxlength="50" size="49" value='<?php echo $topicTitle; ?>'/>
			    
                
                <p class="formText">Description:</p>
                <textarea class="textAreaInputField" name="forumDescription" rows="10" cols="50" wrap="hard" ><?php echo $topicDesc;?></textarea><br/><br/>
                
                
                
                <button class="formBtn" type="submit" class="formSubmit" id="submitBtn">Submit</button>  
                <button class="formBtn" type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button>
			<?php if($errorMessage != ""){ 
                		echo $errorMessage; 
            		} ?><br/><br/>
			</form>
            
		</div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>
