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
    
    if ($_POST){
        if (isset($_POST['editDel'])){
            
            $ProjID = $_GET['projID'];
            if($_POST['editDel'] == "edit"){
                
            }
            if($_POST['editDel'] == "delete"){
                $sql = 'DELETE FROM ADMINPROJECTS WHERE ProjectID = '.$_POST['projID'];
                if(mysqli_query($db, $sql)){
                    header('location: adminProjects.php');
                }
                else{
                    echo "ERROR: Could not delete entry". mysqli_error($db);
                }
            }
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
<?php include('adminNavigationBar.php'); ?>

<div class="projectPostContainer">
<h2 class="subTitle"><?php echo $_SESSION['username'] . " ";?>'s Projects Ideas</h2>
<!-- a listing similar to reddit -->
<ul class="projectList" id="projectList">
<?php
    
    $userID = $_SESSION['id'];
    //projects are ordered by the following calculation: likes - dislikes.
    //highest value of that result will be at the top of the list, regardless of highest percentage ratio
    $sql_query = "SELECT DISTINCT ADMINPROJECTS.ProjectID,
    ADMINPROJECTS.Title,
    ADMINPROJECTS.Details,
    ADMINPROJECTS.Tags,
    ADMINPROJECTS.DateCreated
    FROM ADMINPROJECTS
    INNER JOIN ADMIN ON ADMINPROJECTS.AdminID='". $userID . "'";
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())
        {
            
            echo '<li class="projectItem searchItem hvr-bounce-to-right">';
            echo '<p class="projTitle">' . urldecode($row["Title"]) . '</p>';
            $date = date_create($row["DateCreated"]);
            echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
            echo '<p class="projectIntro">' . urldecode(substr($row["Details"], 0, 200)) . '...</p><br/>';
            echo '<p class="projLikes">' . $row["Tags"] . '</p><br/>';
            ?>
<form action = "adminProjects.php" method = "post">
<input type="hidden" name="projID" value="<?php echo $row['ProjectID']?>">
<button type="submit" class="formBtn" style="text-decoration:none; color:#FFFFFF; font-family: Times New Roman;" name= "editDel" value="edit">Edit</a></button>
<button type="submit" class="formBtn" style="text-decoration:none;color:#FFFFFF;font-family:Times New Roman;" name="editDel" value="delete" >Delete</a></button>
</form>
<?php
    echo "</li>";
				}
    }
    else
    {
        echo 'No Project Ideas have been created yet!';
    }
    mysqli_free_result($result);
    mysqli_close($db);
    
    
    ?>
</ul>
</div>

<div class="footer">
<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
</div>
<script>
</script>
</body>
</html>
