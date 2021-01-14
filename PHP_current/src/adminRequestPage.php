<?php

session_start();

//Database information
$servername = "localhost";
$username = "root";
$password = "5946618570";
$dbname = "BTS_db";

    
    $errorMessage = "";
    $valid = false;
    //connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);
    include ('sessionCheck.php');
    
    if ($_POST){
        if (isset($_POST['sortBtn']))
        {
            if  ($_POST['sortBtn'] == "1")
            {
                $_SESSION["sortBy"] = 'DateCreated DESC';
            }
            else
            {
                $_SESSION["sortBy"] = 'Views DESC';
            }
        }
        
        if( isset($_POST['decide'])){
            
            if($_POST['decide'] == "decline"){
                
                $sql = 'DELETE FROM ADMINPROJ_REQUEST WHERE RequestID = '.$_POST['reqID'];
                if(mysqli_query($db, $sql)){
                    header('location: adminRequestPage.php');
                }
                else{
                    echo "ERROR: Could not delete entry". mysqli_error($db);
                }
                
            }else if($_POST['decide'] == "accept"){
                
                
                $title="";
                $details="";
                $tags="";
                $file="";
                //Get all data from the Admin Projects
                $sql_query = 'SELECT * FROM ADMINPROJECTS WHERE ProjectID = '.$_POST['projID'];
                $result = mysqli_query($db, $sql_query) or die($db);
                
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $title = $row["Title"];
                        $details = $row["Details"];
                        $tags = $row["Tags"];
                        $file = $row["file"];
                    }
                }
                mysqli_free_result($result);
                
                $sql_query = 'INSERT INTO PROJECT set ProjectID=NULL, StudentID="' . $_POST['stuID'] . '", Title="' . $title . '",
                Details="' . $details .'", Tags="' . $tags . '", file="'.$file.'"';
                //Run our sql query
                $result = mysqli_query($db, $sql_query)or die('query failed'. mysqli_error($db));
                
                if($result){
                    $sql_query = 'SELECT ProjectID FROM PROJECT WHERE ProjectID = LAST_INSERT_ID()';
                    
                    $result = mysqli_query($db, $sql_query) or die($db);
                    
                    $newProjectID = -1;
                    
                    if ($result2->num_rows > 0)
                    {
                        while($row = $result->fetch_assoc())
                        {
                            $newProjectID = $row["ProjectID"];
                        }
                    }
                    
                    mysqli_free_result($result2);
                    
                    //When someone creates a project they are automatically in a group and are the group leader
                    $sql_query2 = 'INSERT INTO GROUP_LIST set GroupID=NULL, GroupName="' . $title . '",
                    ProjectID="' . $newProjectID . '",
                    GroupCount="0",
                    GroupLimit="5"';
                    
                    $result = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
                    
                    //--------------------------------------------------------------------------------------------------------
                    $sql_query = "SELECT * FROM GROUP_LIST WHERE ProjectID='" . $newProjectID . "'";
                    
                    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                    $row = mysqli_fetch_assoc($result);
                    
                    $groupID = $row['GroupID'];
                    
                    mysqli_free_result($result);
                    
                    $sql_query = "INSERT INTO GROUP_MEMBERS set GroupID='" . $groupID . "', StudentID='" . $_POST['stuID']  . "'";
                    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                    
                    if($file){
                        
                        $sql = 'UPDATE FILES SET ProjectID ="'.$newProjectID.'" WHERE RequestID = '.$_POST['projID'];
                        mysqli_query($db, $sql) or die('query failed'. mysqli_error($db));
                        
                    }
                    
                    $sql = 'DELETE FROM ADMINPROJECTS WHERE ProjectID = '.$_POST['projID'];
                    mysqli_query($db, $sql)or die('query failed'. msqli_error);
                    
                    $sql = 'DELETE FROM ADMINPROJ_REQUEST WHERE RequestID = '.$_POST['reqID'];
                    mysqli_query($db, $sql)or die('query failed'. msqli_error);
                    
                    header('location: adminRequestPage.php');
                    
                }
            }else{
                
                $sql = 'UPDATE ADMINPROJ_REQUEST SET HasRead = 1 WHERE RequestID = '.$_POST['reqID'];
                if(mysqli_query($db, $sql)){
                    header('location: adminRequestPage.php');
                }
                else{
                    echo "ERROR: Could not delete request". mysqli_error($db);
                }
            }
        }
    }
    
 
        $_SESSION["sortBy"] = 'DateCreated DESC';
    
    ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />

<style>
#overlay {
position: absolute;
display: none;
width: 60%;
height: 60%;
top: 110px;
left: 460px;
right: 0;
bottom: 0;
background-color: rgba(0,0,0,0.8);
z-index: 2;
cursor: pointer;
margin-left: -200px;
margin-right: -200px;
cursor: pointer;
overflow: scroll;
}

#text{
position: relative;
top: 60%;
left: 50%;
font-size: 30px;
color: white;
transform: translate(-50%,-50%);
-ms-transform: translate(-50%,-50%);
}
</style>

</head>
<body>

<?php
    include('adminNavigationBar.php');
    ?>

<div class="projectPostContainer">
<div class="tab">
<form action = "adminRequestPage.php" method = "post">
<button type="submit" class="tablinks" name="sortBtn" value="1" <?php if ($_SESSION['sortBy'] == 'DateCreated DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>New</button>
<button type="submit" class="tablinks" name="sortBtn" value="2" <?php if ($_SESSION['sortBy'] == 'Views DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>Views</button>
</form>
</div>

<ul class="projectList" id="projectList">
<?php
    $sql_query = 'SELECT RequestID, AdminID, StudentID, Message, AdminProjID, DateRequested FROM ADMINPROJ_REQUEST' ;
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            ?>

<?php
    echo '<li class="projectItem hvr-bounce-to-right">';
    echo '<p class="projTitle"> User with ID no: ' . $row["StudentID"] . ' requested to take over project with ID no: '. $row['AdminProjID'].' </p>';
    echo '<p class="projectIntro">' . substr($row["Message"], 0, 50) . '...</p><br/>';
    $date = date_create($row["DateRequested"]);
    echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
    ?><button onclick = "on()">Read Full Message</button></br></br>
<form action = "adminRequestPage.php" method = "post">
<input type="hidden" name=" reqID" value="<?php echo $row['RequestID']?>">
<input type="hidden" name=" projID" value="<?php echo $row['AdminProjID']?>">
<input type="hidden" name=" stuID" value="<?php echo $row['StudentID']?>">
<button type="submit" class="tablinks" name="decide" value="decline" >Decline</button>
<button type="submit" class="tablinks" name="decide" value="accept" >Accept</button>
<button type="submit" class="tablinks" name="decide" value="ignore" >Ignore for Now</button>
</form></li>
<div id="overlay" onclick="off();">
<div id="text"><?php echo $row['Message']?></div>
</div>
<?php
}
}
else
{
				echo 'No Requests .';
}
mysqli_free_result($result);



?>
</ul>
</div>

<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>

<script>
function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}
</script>

<?php
    mysqli_close($db);
    ?>
</body>
</html>
