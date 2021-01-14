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
    
    if ($_POST)
    {
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
    }
    
    
    $_SESSION["sortBy"] = 'DateCreated DESC';
    
    
    ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
</head>
<body>

<?php
    include('adminNavigationBar.php');
    ?>

<div class="projectPostContainer">
<div class="tab">
<form action = "adminHomePage.php" method = "post">
<button type="submit" class="tablinks" name="sortBtn" value="1" <?php if ($_SESSION['sortBy'] == 'DateCreated DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>New</button>
<button type="submit" class="tablinks" name="sortBtn" value="2" <?php if ($_SESSION['sortBy'] == 'Views DESC') {echo 'style="background-color: #3b5998;color:#FFFFFF;"';} ?>>Views</button>
</form>
</div>
<ul class="projectList" id="projectList">
<?php
    $sql_query = 'SELECT ADMINPROJECTS.ProjectID, ADMINPROJECTS.Title, ADMINPROJECTS.Details, ADMINPROJECTS.Tags, ADMINPROJECTS.DateCreated, ADMINPROJECTS.Views, ADMIN.AdminName FROM ADMINPROJECTS INNER JOIN ADMIN ON ADMINPROJECTS.AdminID=ADMIN.AdminID ORDER BY ' . $_SESSION['sortBy'];
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc())
        {
            echo '<li class="projectItem hvr-bounce-to-right">';
            echo '<p class="projTitle">' . $row["Title"] . '</p>';
            echo '<p class="projAuthor">' . $row['AdminName'] . '</p>';
            $date = date_create($row["DateCreated"]);
            echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
            echo '<p class="projectIntro">' . substr($row["Details"], 0, 200) . '...</p><br/>';
            echo '<p class="projLikes">' . $row["Tags"] . '</p><br/>';
            
            echo '<p class="projLikes">Views: ' . $row["Views"] . '</p>';
            echo '</li>';
        }
    }
    else
    {
        echo 'No Projects Uploaded Yet.';
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
