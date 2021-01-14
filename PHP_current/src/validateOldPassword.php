<?php

/*
Group: 22
BTS630
File: validateOldPassword.php
*/

$errors = array(); 

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

//If the user has submitted the password information
if($_POST){ 
      
    //Test for nothing entered in field
	if ($_POST['password'] == "") {
		array_push($errors, "Password is required");
	}else{
        $oldPassword = $_POST['password'];
        $studentID = $_POST['studentId'];
    
     //SQL Query to search for a student matching a studentID and password
        $sql_query = 'SELECT * FROM USER WHERE StudentID="' . $studentID . '" and Password = "'. $oldPassword .'"';   
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        $row  = mysqli_fetch_array($result);
        
        if(is_array($row)){   
            mysqli_free_result($result);
            mysqli_close($db);  
            header("location: changePasswordPage.php?id=" . $studentID . "");
        }else{
            array_push($errors, "The password entered is incorrect");  
        }
	}
        mysqli_free_result($result);
        mysqli_close($db);  
}else{
    mysqli_close($db);   
}

?>