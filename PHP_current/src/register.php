<?php

/*
Group: 22
BTS530
File: register.php
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

//If the user has submitted the registration information
if($_POST){ 
    
    //Test for nothing entered in field
	if ($_POST['username'] == "") {
		array_push($errors, "Username is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['email'] == "") {
		array_push($errors, "Email is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
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
    
    $username = $_POST['username'];
    $password_1 = $_POST['password'];
    $password_2 = $_POST['repassword'];
    $email = $_POST['email'];

    if ($password_1 != $password_2) {
	   array_push($errors, "The two passwords do not match");
       $dataValid = false;
       $valid = false; 
    }else{		
		$dataValid = true;
    }
    
//check the database to make sure a user does not already exist with the same username and/or email

    //SQL Query to search for a student matching a username and password
    $sql_query = 'SELECT * FROM USER WHERE Username="' . $username . '"'; 
    
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $row  = mysqli_fetch_array($result);
    
//If a match is found, then output error message
    if(is_array($row)){
        array_push($errors, "Username already exists");
        $dataValid = false;
        $valid = false; 
    }else{
        $dataValid = true;
    }

    
    //SQL Query to search for a student matching a username and password
    $sql_query = 'SELECT * FROM USER WHERE Email="' . $email . '"'; 
    
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $row  = mysqli_fetch_array($result);

//If a match is found, then output error message    
    if(is_array($row)){
        array_push($errors, "Email already exists");
        $dataValid = false;
        $valid = false; 
    }else{
        $dataValid = true;
    }
    

    if($valid){
        
        //Our SQL Query
        $userName = $_POST['username'];
		$passwords = $_POST['password'];
		$emails = $_POST['email'];
		
		//stores StudentID of new user
		$studentID = 0;

        
        //To hash the password
        //$password = md5($password_1);//encrypt the password before saving in the database
		
		//Create a STUDENT first to generate StudentID
		//This query creates a Student with all default values (except for StudentID)
		$sql_query = 'INSERT INTO STUDENT VALUES()';
		$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
		//LAST_INSERT_ID() gets the last ID created
		$sql_query = 'SELECT * FROM STUDENT WHERE StudentID = LAST_INSERT_ID()';
		$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$studentID = $row["StudentID"];
			}
		} else {
			echo 'error';
		}
		
        $sql_query = 'INSERT INTO USER set Username="' . $userName . '", Email="' . $emails . '",
		Password="' . password_hash($passwords, PASSWORD_DEFAULT) .'", StudentID="' . $studentID . '"';
        
        //Run our sql query
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        mysqli_free_result($result);
        mysqli_close($db);
		
		//redirect user to profile edit page
        //header('location: profileNew.php?id=' . $studentID);
        header('location: sendVerification.php?id=' . $studentID);
        echo "User has been created!";
    }else{
        mysqli_close($db);   
    }
}


    

  

  

  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    



