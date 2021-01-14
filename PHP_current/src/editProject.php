<?php

/*
Group: 22
BTS530
File: editProject.php
*/

session_start();

$errors = array(); 

//Validation variables
$dataValid = true;
$valid = false;

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);


if($_POST){ 
//If the user has submitted the registration information
    
	//Test for nothing entered in field
	if ($_POST['projectTags'] == "") {
		array_push($errors, "Project Tags are required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
        $valid = true;
	}

	//Test for nothing entered in field
	if ($_POST['projectSummary'] == "") {
		array_push($errors, "Summary is required");
		$dataValid = false;
		$valid = false; 
	}else{

		$dataValid = true;
        $valid = true;
	}

	$projectTags = $_POST['projectTags'];
	$projectSummary = $_POST['projectSummary'];
    $projectID = $_POST['projectId'];
       
    if($valid){
        
        //Deleting selected files
        $filePath = "uploadedFiles/";
        if(!empty($_POST["File"])){
            foreach($_POST["File"] as $selectedfiles){
                
                $fullPath = $filePath;
                $fullPath .= $selectedfiles;
                
                if(!unlink($fullPath)){
                    array_push($errors, "File was not deleted.");
                }else{
                    $sql_query= "DELETE FROM FILES WHERE FILESAVENAME='".$selectedfiles."'; ";
                    $result = mysqli_query($db, $sql_query);
                    $NumFiles = $_POST["NumFiles"];
                    if($NumFiles == count($selectedfiles)){
                        $sql_query= "UPDATE PROJECT SET FILE = 0 WHERE ProjectID='".$projectID."'";
                        $result = mysqli_query($db, $sql_query);
                    }
                    mysqli_free_result($result);
                }
            }
        }
        
        
        //Uploading selected files
        //check if any files where uploaded
        //declare filename for later use
        $fileNamesNew = array();
        $fileNames = array();
        $fileExists =0;
        
        if(!empty(array_filter($_FILES['fileToUpload']['name']))){
            
            $fileCount = count($_FILES['fileToUpload']['name']);
            $fileExists = 1;
            for($i = 0; $i < $fileCount; $i++ ){
                
                $file = $_FILES['fileToUpload'];
                
                $fileNameNew="";
                $fileName = basename($_FILES['fileToUpload']['name'][$i]);
                $fileTmpName = $_FILES['fileToUpload']['tmp_name'][$i];
                $fileSize = $_FILES['fileToUpload']['size'][$i];
                $fileError = $_FILES['fileToUpload']['error'][$i];
                $fileType = $_FILES['fileToUpload']['type'][$i];
                
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                $allowedTyps= array("jpeg", "jpg", "png", "pdf", "docx", "txt", "zip");
                
                if(in_array($fileExt, $allowedTyps)){
                    if($fileError === 0){
                        if($fileSize < 4000000){
                            $fileNameNew = uniqid('').".".$fileExt;
                            $fileDestination = "uploadedFiles/".$fileNameNew;
                            
                            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$i], $fileDestination)){
                                echo "Uploaded successfully";
                            }else{
                                echo "error uploading ".$fileName;
                            }
                            
                            array_push($fileNames, $fileName);
                            array_push($fileNamesNew, $fileNameNew);
                            
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
                
                for($i = 0; $i < count($fileNames); $i++){
                    
                    $sql_query = 'INSERT INTO FILES set ProjectID="'.$projectID.'", fileSaveName="'.$fileNamesNew[$i].'", actSaveName="'.$fileNames[$i].'"';
                    $result = mysqli_query($db, $sql_query) or die('query into file table failed'. mysqli_error($db));
                    mysqli_free_result($result);
                }
                
                $sql_query= "UPDATE PROJECT SET FILE =1 WHERE ProjectID='".$projectID."'";
                $result = mysqli_query($db, $sql_query);
                mysqli_free_result($result);
            }
            
        }
        
        //Our SQL Query
       $projectTags = htmlspecialchars($_POST['projectTags'], ENT_QUOTES);
	   $projectSummary = htmlspecialchars($_POST['projectSummary'], ENT_QUOTES);
        $projectID = $_POST['projectId'];
                
        $sql_query = "UPDATE PROJECT SET Tags='".$projectTags."', 
            Details='".$projectSummary."' WHERE ProjectID='".$projectID."'";
        
        //Run our sql query
        $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
        mysqli_free_result($result);
        mysqli_close($db);
		
        $newURL = 
		//make sure to change to this to profile edit page later
        header("location: projectDetails.php?id=" . $projectID . "");
        echo "Project has  been editted!";
    }else{
        
        header("location: projectEdit.php?projectid=" . $projectID . "");
        mysqli_close($db);   
    }
}
