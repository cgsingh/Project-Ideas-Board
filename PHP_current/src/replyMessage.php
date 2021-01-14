<?php

/*
Group: 22
BTS530
File: projectPost.php
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

if ($_GET['id'] == $_SESSION['id'])
{
	header('location: inbox.php');
}

$recipientName = "";

$sql_query = "SELECT USER.Username FROM USER WHERE StudentID='" . $_GET['id'] . "';";
$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$recipientName = $row["Username"];
	}
}
mysqli_free_result($result);

    if ($_POST)
    {
        if ($_SESSION['id'])
        {
			
			if ($_POST['messageBody'] == "") {
                array_push($errors, "Body is required");
                $valid = false;
            }else{
                
                $valid = true;
            }
			
			if ($valid)
			{
				if ($_GET['id'] != $_SESSION['id'])
				{
					$sql_query = 'INSERT INTO INBOX set StudentID="' . $_SESSION['id'] . '", RecipientID="' . $_GET['id'] . '", Body="' . $_POST['messageBody'] . '", ParentMessageID="' . $_GET['mid'] . '", Title="REPLY";';
					
					if ($_GET["pid"])
					{
						$sql_query = 'INSERT INTO INBOX set StudentID="' . $_SESSION['id'] . '", RecipientID="' . $_GET['id'] . '", Body="' . $_POST['messageBody'] . '", ParentMessageID="' . $_GET['pid'] . '", Title="REPLY";';
					}
					
					$result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));;
					mysqli_free_result($result);
					
					if (!$_GET["pid"])
					{
					$sql_query = 'UPDATE INBOX set HasReplied=1 WHERE MessageID=' . $_GET['mid'] . " AND ParentMessageID IS NULL";
					}
					else
					{
						$sql_query = 'UPDATE INBOX set HasReplied=1 WHERE MessageID=' . $_GET['pid'] . " AND ParentMessageID IS NULL";
					}
					
					$result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));;
					mysqli_free_result($result);
					
					
					if ($_GET["pid"])
					{
						$sql_query = 'SELECT RecipientID FROM INBOX WHERE MessageID=' . $_GET['pid'];
						$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc())
							{
								$rid = $row["RecipientID"];
							}
							mysqli_free_result($result);
							if ($rid == -1)
							{
								$sql_query = 'UPDATE INBOX set RecipientID=' . $_GET['id'] . " WHERE MessageID=" . $_GET['pid'];
					
								$result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));;
								mysqli_free_result($result);
							}
						}
					}
					
					mysqli_close($db);
					if ($_GET["pid"])
					{
						header('location: message.php?id=' . $_GET["pid"]);
					}
					else
					{
						header('location: message.php?id=' . $_GET["mid"]);
					}
				}
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
            header('location: loginPage.php');
        }
        
        
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
			<form class="formStyle" action="" method="post">
			<h2 class="formTitle">Recipient: <?php echo $recipientName; ?></h2>
			<p class="formText">Body:</p>
			<textarea class="textAreaInputField" name="messageBody" rows="10" cols="50" wrap="hard" ></textarea><br/><br/>
			<button class="formBtn" type="submit" class="formSubmit" id="submitBtn">Send</button>  
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
