<?php

session_start();

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

    $errorMessage = "";
    
    //connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);
    include ('sessionCheck.php');
    
    if (!checkSession()) {
        header("location: loginRequired.php");
    }
    $errors = array();
    
    //Validation variables
    $dataValid = true;
    $valid = false;
    
    if ($_POST)
    {
        if ($_SESSION['id'])
        {
            //Test for nothing entered in field
            if ($_POST['requestSummary'] == "") {
                array_push($errors, "Summary is required");
                $dataValid = false;
                $valid = false;
            }else{
                
                $valid = true;
            }
            
            $requestMessage = htmlspecialchars($_POST['requestSummary'], ENT_QUOTES);
            $adminID = $_POST['adminID'];
            $adminProjectID= $_POST['projID'];
            
            
            if ($valid)
            {
                
                $sql_query = 'INSERT INTO ADMINPROJ_REQUEST set RequestID=NULL, AdminID="' . $adminID . '", StudentID="'.$_SESSION['id'].'", Message="' . $requestMessage . '", AdminProjID="'.$adminProjectID.'"';
                //Run our sql query
                $result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));;
                mysqli_free_result($result);
                
                mysqli_close($db);
                //have this link to the project details page
                header('location: adminProjectList.php');
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
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
</head>
<body>
<?php include('navigationBar.php'); ?>

<div class="projectPostContainer">
<div class="tab">
<h2 class="tablinks" style="background-color: #3b5998;color:#FFFFFF;">Resquest Project</h2>
</div>
<ul class="projectList" id="projectList">
<?php
    $projectID = $_GET["id"];
    $sql_query = 'SELECT AdminID,
    ProjectID,
    Title,
    Details,
    Tags,
    DateCreated,
    Views
    FROM ADMINPROJECTS WHERE ProjectID = '.$projectID;
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $ProjAdminID = "";
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())
        {
            echo '<li class="projectItem hvr-bounce-to-right">';
            echo '<p class="projTitle">' . $row["Title"] . '</p>';
            $date = date_create($row["DateCreated"]);
            echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
            echo '<p class="projectIntro">' . substr($row["Details"], 0, 50) . '...</p><br/>';
            echo '<p class="projLikes">' . $row["Tags"] . '</p><br/>';
            echo '</li>';
            $ProjAdminID = $row['AdminID'];
            //add button to request to take over project
        }
    }
    else
    {
        echo 'No Project Ideas have been created yet!';
    }
    mysqli_free_result($result);
    
    //check if this student has already requested for this project------
    
    $sql_query = 'Select StudentID from ADMINPROJ_REQUEST WHERE AdminProjID ="'.$projectID.'"';
    $result = $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $reqsIDs = array();
    $i =0;
    if ($result->num_rows > 0) {
        while($row2 = $result->fetch_array(MYSQLI_NUM))
        {
            $reqsIDs[] = $row2[$i];
            $i++;
        }
    }
    mysqli_free_result($result);
    
    if(in_array($_SESSION['id'], $reqsIDs)){
        echo '<h2 class="formTitle">You have already requested for this project.</h2>';
    }else{
        ?>

<div class="formContainer" style="margin-top: 15px;">

<form class="formStyle" action="adminProjRequest.php" method="post">
<h2 class="formTitle">Request Message</h2>
<input type="hidden" name="adminID" value="<?php echo $ProjAdminID?>">
<input type="hidden" name="projID" value="<?php echo $projectID?>">
<p class="formText">Summary</p>
<textarea class="textAreaInputField" name="requestSummary" rows="13" cols="90" wrap="hard" ></textarea><br/>
<button class="formBtn" type="submit" class="formSubmit" id="requestBtn">Request</button>
<button class="formBtn" type="button" class="formSubmit" name="submitted" value="Cancel" onClick="window.location='homePage.php';">Cancel</button>
<?php if($errorMessage != ""){
    echo $errorMessage;
} ?><br/><br/>
</form>
<?php
    }
    
    ?>
<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>
<script>
</script>
</body>
</html>
