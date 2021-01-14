<?php

/*
Group: 22
BTS630
File: validatePassword.php
*/


$errors = array(); 

//Validation variables
$dataValid = true;
$valid = "false";

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
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    // Test for nothing entered in field
	if ($_POST['repassword'] == "") {
		array_push($errors, "You must retype the password");
		$dataValid = false;
		$valid = false; 
	}else{
	
		$dataValid = true;
	}
    
    $password_1 = $_POST['password'];
    $password_2 = $_POST['repassword'];
    $studentID = $_POST['studentId'];

    if ($password_1 != $password_2) {
	   array_push($errors, "The two passwords do not match");
       $dataValid = false;
       $valid = false; 
    }else{		
		$dataValid = true;
    }
    
    if($valid){  
		$sql_query = "UPDATE USER SET Password='".$password_1."' WHERE StudentID='".$studentID."'";    
		$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        mysqli_free_result($result);
        mysqli_close($db);      
        header('location: homePage.php');
    }else{
        mysqli_close($db);   
    }
}

?>