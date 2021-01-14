<?php

/*
Group: 22
BTS530
File: editProfile.php
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
    
    //check if any files where uploaded
    //declare filename for later use
    $fileNamesNew = "";
    $fileNames = "";
    $fileExists =0;
    
    if(isset($_FILES['profilePic'])){
        
        $fileCount = count($_FILES['profilePic']['name']);
        $fileExists = 1;
        
        $file = $_FILES['profilePic'];
        
        $fileNameNew="";
        $fileName = basename($_FILES['profilePic']['name']);
        $fileTmpName = $_FILES['profilePic']['tmp_name'];
        $fileSize = $_FILES['profilePic']['size'];
        $fileError = $_FILES['profilePic']['error'];
        $fileType = $_FILES['profilePic']['type'];
        
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        $allowedTyps= array("jpeg", "jpg", "png");
        
        if(in_array($fileExt, $allowedTyps)){
            if($fileError === 0){
                if($fileSize < 4000000){
                    $fileNameNew = $fileName;
                    $fileDestination = "uploadedFiles/profiles/".$fileNameNew;
                    
                    if(move_uploaded_file($_FILES['profilePic']['tmp_name'], $fileDestination)){
                        
                    }else{
                        array_push($errors, "error uploading ".$fileName);
                    }
                    
                    $fileNamesNew= $fileNameNew;
                    
                }else{
                    array_push($errors, "File is to big. No more than 4MB");
                    $dataValid = false;
                    $valid = false;
                }
            }else{
                array_push($errors, "Error while uploading file");
                $dataValid = false;
                $valid = false;
            }
            
        }else{
            array_push($errors, "Can not upload files of this type.");
            $dataValid = false;
            $valid = false;
        }
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
        $userID = $_SESSION['id'];
                
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
        mysqli_free_result($result);
        
        //If a profile pic other than the default existed delete it before replacing the name in the database
        $sql_query = "SELECT ProfilePic from STUDENT WHERE STUDENTID='".$userID."'";
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $oldProfilePic = $row['ProfilePic'];
                                       
            if($oldProfilePic !== "default_avatar.png"){
                    $filePath = "uploadedFiles/profiles/";
                    $fullPath = $filePath;
                    $fullPath .= $oldProfilePic;
                            if(!unlink($fullPath)){
                                    array_push($errors, "Old Profile Image was not deleted due to errors");
                            }
            }
                                       
        //If a profile pic has been uploaded save it in student table
        if(!empty($fileNamesNew)){
                        $sql_query= "UPDATE STUDENT SET profilePic ='".$fileNamesNew."' WHERE StudentID ='".$userID."';";
                        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                        mysqli_free_result($result);
		}
                                       
        mysqli_close($db);
		
		//make sure to change to this to profile edit page later
        header('location: profilePage.php');
        echo "Profile has  been editted!";
    }else{
        header('location: profileEdit.php');
        mysqli_close($db);   
    }
}
