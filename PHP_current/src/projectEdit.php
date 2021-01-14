<?php
    
    /*
     Group: 22
     BTS530
     File: projectEdit.php
     */
    
    include('editProject.php');
    
    ?>
<?php
    session_start();
    
    if ($_SESSION['id']=="") {
        header('location: loginPage.php');
    }
    
    //Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";
    
    $errorMessage = "";
    
    //connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);
    
    ?>


<?php
    
    //$sql_query2 = 'SELECT * FROM USER INNER JOIN STUDENT ON USER.StudentID=STUDENT.StudentID ';
    $userID = $_SESSION['id'];
    $projectID = $_GET["projectid"];
    $sql_query = "SELECT PROJECT.Title, PROJECT.Details, PROJECT.Tags, PROJECT.File FROM PROJECT
    WHERE PROJECT.ProjectID='" . $projectID . "'";
    
    
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    
    
    $title = $row['Title'];
    $details = $row['Details'];
    $tags = $row['Tags'];
    $files = $row['File'];
    $fNames= array();
    $actFNames= array();
    
    ?>

<html>
<head>
		<link rel="stylesheet" type="text/css" href="css/register.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
</head>
<body>
<?php include('navigationBar.php'); ?>
<div class="formContainer">
<form class="formStyle" action="projectEdit.php" method="post" enctype="multipart/form-data">
<h2 class="formTitle">Edit Project: <?php echo $title; ?></h2>
<p class="formText">Tags:</p>
<input type="text" class="formInputField" id="projectTagsField" name="projectTags" maxlength="50" size="51" value='<?php echo $tags;?>' required/>
<p class="formText">Summary:</p>
<textarea class="textAreaInputField" id="projectSummaryField" name="projectSummary" rows="10" cols="50" wrap="hard" required><?php echo $details;?></textarea><br/>
<input type="hidden" name="projectId" value='<?php echo $projectID;?>' />
<input type="hidden" name="userId" value='<?php echo $userID;?>' />
<?php
    if($files == 1){
        ?><p class="formText">Files:</p><?php
$sql_query = "SELECT fileSaveName, actSaveName FROM FILES WHERE ProjectID ='".$projectID."';";
$result =  mysqli_query($db, $sql_query) or die('query select from files has failed'. mysqli_error($db));
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        array_push($fNames,$row['fileSaveName']);
        array_push($actFNames, $row['actSaveName']);
    }
}

?>
<input type="hidden" name="NumFiles" value='<?php echo count($fNames);?>' />
<?php
for($i=0; $i< count($fNames); $i++){
    ?>
    <input type= "checkbox" name= "File[]" value="<?php echo $fNames[$i]; ?>"/><?php echo $actFNames[$i]; ?>
    <?php
}

mysqli_free_result($result);
}
mysqli_close($db);
?>
</br></br><input  type="file" name="fileToUpload[]" multiple/></br><button type="submit" class="formSubmit formBtn" id="submitBtn">Post</button>
<button type="button" class="formSubmit formBtn" name="submitted" value="Cancel" onClick="window.location='myProjectsPage.php';">Cancel</button><br/>
<?php include('errors.php'); ?>
</form>
</div>
<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>
</body>
</html>
