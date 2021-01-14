<?php

/*
Group: 22
BTS530
File: projectPost.php
*/
//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

//connect to the database
$db = new mysqli($servername, $username, $password, $dbname);

session_start();

include ('sessionCheck.php');
if (!checkSession()) {
	header("location: loginRequired.php");
}
$errors = array(); 

//Validation variables
$dataValid = true;
$valid = false;

    //if user has posted a new project and double checking to make sure they're logged in
    if ($_POST)
    {
        if ($_SESSION['id'])
        {
            
            //Test for nothing entered in field
            if ($_POST['projectTitle'] == "") {
                array_push($errors, "Project Title is required");
                $dataValid = false;
                $valid = false;
            }else{
                
                $dataValid = true;
            }
            
            //Test for nothing entered in field
            if ($_POST['projectTags'] == "") {
                array_push($errors, "Project Tags are required");
                $dataValid = false;
                $valid = false;
            }else{
                
                $dataValid = true;
            }
            
            //Test for nothing entered in field
            if ($_POST['projectSummary'] == "") {
                array_push($errors, "Summary is required");
                $dataValid = false;
                $valid = false;
            }else{
                
                $dataValid = true;
            }
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
                    
                }
                
            }
            
            $projectTitle = htmlspecialchars($_POST['projectTitle'], ENT_QUOTES);
            $projectTags = htmlspecialchars($_POST['projectTags'], ENT_QUOTES);
            $projectSummary = htmlspecialchars($_POST['projectSummary'], ENT_QUOTES);
				
            
            if ($valid)
            {
				
                $sql_query = 'INSERT INTO PROJECT set ProjectID=NULL, StudentID="' . $_SESSION['id'] . '", Title="' . $projectTitle . '",
                Details="' . $projectSummary .'", Tags="' . $projectTags . '", file="'.$fileExists.'"';
                //Run our sql query
                $result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));;
                mysqli_free_result($result);
                
                
                $sql_query = 'SELECT ProjectID FROM PROJECT WHERE ProjectID = LAST_INSERT_ID()';
                
                $result = mysqli_query($db, $sql_query) or die($db);
                
                $newProjectID = -1;
                
                if ($result->num_rows > 0)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $newProjectID = $row["ProjectID"];
                    }
                }
                
                mysqli_free_result($result);
                //$sql_query2 = "INSERT INTO `GROUP` (GroupID, GroupName, ProjectID, //GroupCount, GroupLimit)
                //VALUES ('$newProjectID', '$projectTitle', '$newProjectID', 0, 5)";
                
                //$result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
                
                //When someone creates a project they are automatically in a group and are the group leader
                $sql_query2 = 'INSERT INTO GROUP_LIST set GroupID=NULL, GroupName="' . $projectTitle . '",
                ProjectID="' . $newProjectID . '",
                GroupCount="0",
                GroupLimit="5"';
                
                $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
                
                mysqli_free_result($result2);
                
                //--------------------------------------------------------------------------------------------------------
                $sql_query2 = "SELECT * FROM GROUP_LIST WHERE ProjectID='" . $newProjectID . "'";
                
                $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
                $row = mysqli_fetch_assoc($result2);
                
                $groupID = $row['GroupID'];
                
                mysqli_free_result($result2);
                
                $sql_query3 = "INSERT INTO GROUP_MEMBERS set GroupID='" . $groupID . "', StudentID='" . $_SESSION['id'] . "'";               
                $result3 = mysqli_query($db, $sql_query3) or die('query failed'. mysqli_error($db));
                mysqli_free_result($result3);
                
                for($i = 0; $i < count($fileNames); $i++){        
                    $sql_query = 'INSERT INTO FILES set ProjectID="'.$newProjectID.'", fileSaveName="'.$fileNamesNew[$i].'", actSaveName="'.$fileNames[$i].'"';
                    $result = mysqli_query($db, $sql_query) or die('query into file table failed'. mysqli_error($db));
                    mysqli_free_result($result);
                }
                
                
                mysqli_close($db);
                //have this link to the project details page
                header('location: projectDetails.php?id=' . $newProjectID);
            }
        }
        else
        {
            mysqli_close($db);
            header('location: loginPage.php');
        }
        
        
    }
    ?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/register.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
		<script type="text/javascript">alert(<?php echo $_SESSION['query1']; ?>);</script>
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		<div class="formContainer" style="margin-top: 15px;">
			<form class="formStyle" action="projectPost.php" method="post" enctype="multipart/form-data">
			<h2 class="formTitle">New Project</h2>
			<p class="formText">Project Title:</p>
			<input type="text" class="formInputField" name="projectTitleField" maxlength="50" size="51" />
			<p class="formText">Tags:</p>
			<input type="text" class="formInputField" name="projectTagsField" maxlength="50" size="51" />
			<p class="formText">Summary:</p>
			<textarea class="textAreaInputField" name="projectSummaryField" rows="10" cols="50" wrap="hard" ></textarea><br/>
			<!-- <form class="formStyle" action="projectPost.php" method="post" enctype="multipart/form-data"> -->
			</br><input type="file" name="fileToUpload[]" multiple/><br/><br/>
			<button class="formBtn" type="submit" class="formSubmit" id="submitBtn">Post</button>  
            <button class="formBtn" type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button>
			<?php if($errorMessage != ""){ 
                		echo $errorMessage; 
            		} ?><br/><br/>
			</form>
		</div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>
