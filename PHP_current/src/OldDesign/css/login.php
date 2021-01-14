<?php
//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

    $errorMessage = ""; 
    
//connect to the database
    $db = new mysqli($servername, $username, $password, $dbname);



//If the user has submitted a username and password

if(isset($_POST['username']) && isset($_POST['password'])){
    
    session_start(); //Start Session

//-------------------------------------------------------------------------------------------
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //SQL Query to search for a student matching a username and password
    $sql_query = 'SELECT * FROM USER WHERE Username="' . $username . '" and Password = "'. $password .'"';
    
    $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
    $row  = mysqli_fetch_array($result);
    $accountStatus = $row['AccountStatus'];
    
//If a match is found, then create a session 
 
    if(is_array($row)){   
            $_SESSION["id"] = $row['StudentID'];
            $_SESSION["username"] = $row['Username'];
    }else{
        $errorMessage = "Invalid Username or Password!";
    }

//If a session is created redirect to the home page    
    if(isset($_SESSION["id"]) AND $accountStatus == "1") {
        header("location: homePage.php");
    }else{
        $errorMessage = "You must validate your registered email address!"; 
        unset($_SESSION["id"]);
        unset($_SESSION["name"]);
    }
    
//Free SQL reqult
    mysqli_free_result($result);   
    
//Close the MySQL Link
    mysqli_close($db);
}
else{
//Close the MySQL Link
    mysqli_close($db);
}

?>