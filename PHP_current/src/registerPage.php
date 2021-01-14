<?php 

/*
Group: 22
BTS530
File: registerPage.php
*/

include('register.php') 

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
			<form class="formStyle" method="post" action="registerPage.php">
            
			
            <h2 class="formTitle">Register</h2>
                
			<p class="formText">Username:</p>
			<input type="text" class="formInputField" name="username" required/>
                
			<p class="formText">Password:</p>
			<input type="password" class="formInputField" name="password" required/><br/>
			<p class="formText">Re-enter password:</p>
                
			<input type="password" class="formInputField" name="repassword" required/><br/>
			<p class="formText">E-mail:</p>
                
			<input type="text" class="formInputField" name="email" required/><br/>
            </br>
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