<?php

/*
Group: 22
BTS630
File: enterPassword.php
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

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

$studentID = $_SESSION['id'];

//if($_POST){
include('validateOldPassword.php') 
//}

?>

<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/login.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		<div class="formContainer">
            <form class="formStyle" method="post" action="enterPassword.php">
        
            <h2 class="formTitle">Please Enter your Old password</h2>
                
			<p class="formText">Password:</p>
			<input type="password" class="formInputField" name="password" required/><br/>
            <input type="hidden" name="studentId" value='<?php echo $studentID;?>' /><br/>
                
			<button class="formBtn" type="submit"  class="formSubmit" name="reg_user">Submit</button>
            <button class="formBtn" type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button>
            <?php include('errors.php'); ?><br/><br/>
			</form>
            
		</div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>