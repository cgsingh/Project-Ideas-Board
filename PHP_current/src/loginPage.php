<?php
    
    /*
     Group: 22
     BTS530
     File: loginPage.php
     */
    
    include('login.php');
    
    ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/login.css" />
<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
</head>
<body>
<?php
    include('navigationBar.php'); ?>
<div class="formContainer">
<form class="formStyle" action = "loginPage.php" method = "post">
<h2 class="formTitle">Login</h2>
<p class="formText">Username:</p>
<input type="text" class="formInputField" name="username"/>
<p class="formText">Password:</p>
<input type="password" class="formInputField" name="password"/><br/>
<input type="hidden" id="SSID" name="SSID"/><br/>
<script type="text/javascript">
var ssid = Math.random().toString(36).substr(2) + Math.random().toString(36).substr(2) + Math.random().toString(36).substr(2) + Math.random().toString(36).substr(2);
document.getElementById("SSID").value = ssid;
</script>
<select name= "type">
<option value="Admin">Admin</option>
<option value="User" selected>User</option>
</select><br/><br/>

<button class="formBtn" style="padding: 10px 16px;" type="submit" class="formSubmit" name="submitted" value="Submit">Login</button>
<button class="formBtn"  style="padding: 10px 16px;" type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button><br/><br/>
<a style="color: #FFFFFF;" href="enterEmailAddress.php">Forgot Password.</a><br/>
<a style="color: #FFFFFF;" href="registerPage.php">New to PIB? Sign-up.</a><br/>
<?php if($errorMessage != ""){
    echo $errorMessage;
} ?>
<br />
</form>
</div>
<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>
</body>
</html>
