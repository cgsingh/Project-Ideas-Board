<?php

/*
Group: 22
BTS630
File: sendVerification.php
*/

//Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

$newStudentID = $_GET["id"];

if($newStudentID == ""){
    echo "No email has been sent";
}else{
   
//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

//connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);
    
    $sql_query = "SELECT * FROM USER WHERE StudentID =" . $newStudentID;
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $row = mysqli_fetch_assoc($result);

    $studentID = $row["StudentID"];
    $emailAddress = $row["Email"];
     

//Using the PHPMailer library
//Include required PHPMailer files
    require 'PHPMailer.php';
    require 'SMTP.php';
	require 'Exception.php';

//Create instance of PHPMailer
	$mail = new PHPMailer();

//Set mailer to use smtp
	$mail->isSMTP();

//Define smtp host
	$mail->Host = "smtp.gmail.com";

//Enable smtp authentication
	$mail->SMTPAuth = true;

//Set smtp encryption type (ssl/tls)
	$mail->SMTPSecure = "tls";

//Port to connect smtp
	$mail->Port = "587";

//Set gmail username
	$mail->Username = "projectideasboard@gmail.com";

//Set gmail password
	$mail->Password = "passwordseneca123";

//Email subject
	$mail->Subject = "Project Ideas Board: Unlock your account";

//Set sender email
	$mail->setFrom('projectideasboard@gmail.com');

//Enable HTML text 
	$mail->isHTML(true);

//Email body
	$mail->Body = '<h1>Project Ideas Board</h1>
    </br>
    <p><a href="http://24.239.4.222:55555/PHP/src/profileNew.php?id='.$newStudentID.'"</a>Click here to unlock your account</a></p>';
    

//Add recipient
	$mail->addAddress($emailAddress);

//Send verification email
	if ( $mail->send() ) {
		echo "Email verification has been sent!";
	}else{
		echo "Email could not be sent. Error: "{$mail->ErrorInfo};
	}

//Close smtp connection
	$mail->smtpClose();
    mysqli_close($db);  
}
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
            <h1 style="color:black">Account has been created</h1>
            <h2 style="color:black">Verify your email address to unlock your account</h2>
            <button type="button" class="formSubmit formBtn" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Home Page</button><br/>
            <br />     
        </div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>