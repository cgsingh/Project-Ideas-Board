<?php

/*
Group: 22
BTS630
File: sendPasswordLink.php
*/

$emailAddress = $_GET['id'];
?>

<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/login.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
        <div class="messageContainer formContainer">
            <h1 style="color:black">Password link has been sent</h1>
            <h2 style="color:black">Check your email to change your password</h2>
            <h3 style="color:black">A link has been sent to your email address</h3>
            <p><?php echo $emailAddress; ?></p>
            <button type="button" class="formSubmit formBtn" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Home Page</button><br/>
            <br />     
        </div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>