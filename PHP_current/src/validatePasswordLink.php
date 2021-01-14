<?php

/*
Group: 22
BTS630
File: validatePasswordLink.php
*/


//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

    $db = new mysqli($servername, $username, $password, $dbname);

    $studentID = $_GET["id"];
    $expiryTime = $_GET["ids"];
    $today_date = date('Y-m-d H:i:s');
    $hash_Td = strtotime($today_date);
?>

<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/login.css" />
	</head>
	<body>
	<h1 class="appTitle">Project Ideas Board</h1>
        <div class="messageContainer">
            
            <?php
            
            $sql_query = 'SELECT * FROM EMAILED_LINKS WHERE Expiry="' . $expiryTime . '" AND StudentID="'. $studentID .'"';   
            $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $row  = mysqli_fetch_array($result);         
            $activated = $row['ActivatedLink'];
            
            if($activated == 0){
                if($hash_Td > $expiryTime){
                    echo "The link is expired";
                    echo "<br>";
                    echo '<a href="enterEmailAddress.php">Click here to send another email to change password</a><br/>';
                }else{
                    $sql_query2 = "UPDATE EMAILED_LINKS SET ActivatedLink='1' WHERE StudentID='".$studentID."' AND Expiry='".$expiryTime."'";     
                    $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));      
                    header("location: changePasswordPage.php?id=" . $studentID . "");
                }
            }else{
                echo "This link has already been used";
                echo "<br>";
                echo '<a href="enterEmailAddress.php">Click here to send another email to change password</a><br/>';
            }
            ?>
            <br /> 
            <button type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Home Page</button><br/>
            <br />     
        </div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>