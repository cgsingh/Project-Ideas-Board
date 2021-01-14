<?php 

/*
Group: 22
BTS630
File: changePasswordPage.php
- User must enter a new password and retype the same password
- The posted passwords are validated in the validatePassword.php file
*/

$studentID = $_GET["id"];
include('validatePassword.php') 

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/register.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		<div class="formContainer">
            <form class="formStyle" method="post" <?php echo 'action="changePasswordPage.php?id=' . $studentID . '"' ?>>
        
            <h2 class="formTitle">Please Enter your new password</h2>
                
			<p class="formText">Password:</p>
			<input type="password" class="formInputField" name="password" required/><br/>
			<p class="formText">Re-enter password:</p>   
			<input type="password" class="formInputField" name="repassword" required/><br/>
            <input type="hidden" name="studentId" value='<?php echo $studentID;?>' />
                
			<button type="submit"  class="formSubmit formBtn" name="reg_user">Submit</button>
            <button type="button" class="formSubmit formBtn" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button>
            <?php include('errors.php'); ?>    
			</form>
		</div>
        
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
	</body>
</html>