<?php 

/*
Group: 22
BTS630
File: enterEmailAddress.php
*/

include('retreivePassword.php') 

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
			<form class="formStyle" action = "enterEmailAddress.php" method = "post">
                <h2 class="formTitle">Change Password</h2>
                <p class="formText">Please enter a valid email address:</p>
                <input type="email" class="formInputField" name="email" required/><br/><br/>
                <button class="formBtn" type="submit" class="formSubmit" value="Submit">Submit</button>
                <button class="formBtn" type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button>
            <?php if($errorMessage != ""){ 
                echo $errorMessage; 
            } ?>
            <br/><br/>
			</form>          
		</div>
        
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>