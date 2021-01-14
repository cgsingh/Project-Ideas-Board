<?php

/*
Group: 22
BTS630
File: createProfile.php
*/

session_start();

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

//$userID = $_GET['id'];

//If the user has submitted the registration information
if($_POST){ 
	
    //Test for nothing entered in field
	if ($_POST['firstname'] == "") {
		array_push($errors, "First Name is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['lastname'] == "") {
		array_push($errors, "Last Name is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['address'] == "") {
		array_push($errors, "Address is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['city'] == "") {
		array_push($errors, "City is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['province'] == "") {
		array_push($errors, "Province is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
        //Test for nothing entered in field
	if ($_POST['postalcode'] == "") {
		array_push($errors, "Postal Code is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['country'] == "") {
		array_push($errors, "Province is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['phone'] == "") {
		array_push($errors, "Phone Number is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
    
    //Test for nothing entered in field
	if ($_POST['bioField'] == "") {
		array_push($errors, "Biography is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
	}
        
    if($valid){
        
        //Our SQL Query
        
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $country = $_POST['country'];
        $province = $_POST['province'];
        $postalcode = $_POST['postalcode'];
        $phone = $_POST['phone'];
        $bioField = /*?><script>escape(<?php*/ htmlspecialchars($_POST['bioField'], ENT_QUOTES)/* ?>)</script><?php*/;
        $userID = $_POST['studentId'];
                
        $sql_query = "UPDATE STUDENT SET FirstName='".$firstname."', 
            LastName='".$lastname."', 
            Phone='".$phone."', 
            Address='".$address."', 
            City='".$city."', 
            Province='".$province."', 
            Country='".$country."', 
            PostalCode='".$postalcode."', 
            Biography='".$bioField."' WHERE StudentID='".$userID."'";
        
        //Run our sql query
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        
        $sql_query2 = "UPDATE USER SET AccountStatus=1 WHERE StudentID='".$userID."'";
        
        //Run our sql query 2
        $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
        
        mysqli_free_result($result);
        mysqli_free_result($result2);
        mysqli_close($db);
		
		//make sure to change to this to profile edit page later
        header('location: profilePage.php');
        echo "Profile has  been created!";
    }else{
        header("location: profileNew.php?id=" . $userID . "");
        mysqli_close($db);   
    }
}