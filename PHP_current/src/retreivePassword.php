<?php

/*
Group: 22
BTS630
File: retreivePassword.php
*/

//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

    //Define name spaces
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

    $valid = false;
    
//connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);

//If the user has submitted a username and password
    if($_POST){    
        
        $email = $_POST['email'];
    
//SQL Query to search for a student matching a username and password
        $sql_query = 'SELECT * FROM USER WHERE Email="' . $email . '"';   
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        $row  = mysqli_fetch_array($result);
        $emailAddress = $row['Email'];
        
//If a match is found send an email
        
        if ($result->num_rows == 0){
            echo "The Email Address does not exist";
        }else{
            
            $studentID = $row['StudentID'];
            
//Set Expiry date
            $expiry_date = date("Y-m-d H:i:s", strtotime("+1 day"));
            $hash_Ex = strtotime($expiry_date);
        
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
            $mail->Subject = "Change Password PIB";

//Set sender email
            $mail->setFrom('projectideasboard@gmail.com');

//Enable HTML text 
            $mail->isHTML(true);

//Email body
            $mail->Body = '<h1>Project Ideas Board</h1>
            </br>
            <p><a href="http://24.239.4.222:55555/PHP/src/validatePasswordLink.php?id='.$studentID.'&ids='.$hash_Ex.'"</a>Click here to change your password</a></p><p>This link expires in 24 hours</p>';
    
//Add recipient
            $mail->addAddress($emailAddress);

//Send verification email
            if( $mail->send() ){
                
                $sql_query2 = 'INSERT INTO EMAILED_LINKS set StudentID="' . $studentID . '", Expiry="' . $hash_Ex . '"';
            
//Run our sql query
                $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
                echo "Email verification has been sent!";
                $valid = true;
            }else{
                echo "Email could not be sent. Error: "{$mail->ErrorInfo};   
            }

//Close smtp connection
            $mail->smtpClose();  
        }
    
//Free SQL reqult
        mysqli_free_result($result);
        mysqli_free_result($result2);   
    
//Close the MySQL Link
        mysqli_close($db);
             
    }else{
        
//Close the MySQL Link
        mysqli_close($db);
        $valid = false;
}

if($valid){
   header("location: sendPasswordLink.php?id=" . $emailAddress . ""); 
}


?>