<?php

/*
Group: 22
BTS530
File: login.php
*/

//Database information
    $servername = "localhost";
    $username = "root";
    $password = "5946618570";
    $dbname = "BTS_db";

    $errorMessage = ""; 
    
//connect to the database
    db = new mysqli($servername, $username, $password, $dbname);
    
    
    
    //If the user has submitted a username and password
    
    if(isset($_POST['username']) && isset($_POST['password'])){
        
        session_start(); //Start Session
        
        //Check if admin tried loging in
        $type = $_POST['type'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if($_SESSION['accType'] == ""){
            $_SESSION["accType"] = $type;
        }
        
        if($type == "Admin"){
            
            $sql_query = "SELECT * FROM ADMIN WHERE AdminName = '" . $username . "';";
            $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $row  = mysqli_fetch_array($result);
            
            if($password == $row['AdminPassword']){
                $_SESSION["id"] = $row['AdminID'];
                $_SESSION["username"] = $row['AdminName'];
                
                if(isset($_SESSION["id"])) {
                    
                    if (isset($_COOKIE['SSID'])) {
                        $_SESSION['SSID'] = $_COOKIE['SSID'];
                    } else {
                        $_SESSION['SSID'] = $_POST['SSID'];
                    }
                    
                    $sql_query = 'SELECT * FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_SESSION["SSID"] . '";';
                    $result = mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
                    $row = mysqli_fetch_array($result);
                    $date = (new DateTime('today'))->format('y-m-d');
                    $exp_date = (new DateTime('today'))->modify('+1 week')->format('y-m-d');
                    
                    
                    if (is_array($row)) { // Login Session Exists //
                        
                        if ($_SESSION['id'] == $row['AdminID'] AND $_SERVER['REMOTE_ADDR'] == $row['ClientIP']) {
                            
                            $sql_query = 'UPDATE LOGIN_SESSIONS SET DateCreated = "' . $date . '", DateExpires = "' . $exp_date . '" WHERE LoginKey = "' . $_SESSION["SSID"] . '";';
                            mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
                            setcookie("SSID", $_SESSION['SSID'], time() + 604800, "/");
                            header("location: adminHomePage.php");
                            
                        } else {
                            
                            $errorMessage = "User already logged in, please sign-out of other device before signing in again.";
                            unset($_SESSION["id"]);
                            unset($_SESSION["username"]);
                            
                        }
                        
                    } else { // Create new login session //
                        
                        $sql_query = 'INSERT INTO LOGIN_SESSIONS (LoginKey, ClientIP, ID, DateExpires) VALUES ("' . $_SESSION['SSID'] . '", "' . $_SERVER["REMOTE_ADDR"] . '", "' . $_SESSION["id"] . '", "' . $exp_date . '");';
                        mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
                        setcookie("SSID", $_SESSION['SSID'], time() + 604800, "/");
                        header("location: adminHomePage.php");
                        
                    }
                    
                }
            }
        }else{
            
            
            //SQL Query to search for a student matching a username and password
            $sql_query = "SELECT * FROM USER WHERE Username = '" . $username . "';";
            
            
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
                
                if (isset($_COOKIE['SSID'])) {
                    $_SESSION['SSID'] = $_COOKIE['SSID'];
                } else {
                    $_SESSION['SSID'] = $_POST['SSID'];
                }
                
                $sql_query = 'SELECT * FROM LOGIN_SESSIONS WHERE LoginKey = "' . $_SESSION["SSID"] . '";';
                $result = mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
                $row = mysqli_fetch_array($result);
                $date = (new DateTime('today'))->format('y-m-d');
                $exp_date = (new DateTime('today'))->modify('+1 week')->format('y-m-d');
                
                
                if (is_array($row)) { // Login Session Exists //
                    
                    /*
                     If the login ID and Client IP don't match the ID and IP of the session, the user cannot login.
                     If session matches, the session time is extended
                     The user must sign-out of the other device before logging in again.
                     TODO:
                     - Use a unique ID instead of IP to tie the session to the login.
                     - Allow multiple logins based on the unique ID system
                     - Setup token expiry
                     */
                    
                    if ($_SESSION['id'] == $row['StudentID'] AND $_SERVER['REMOTE_ADDR'] == $row['ClientIP']) {
                        
                        $sql_query = 'UPDATE LOGIN_SESSIONS SET DateCreated = "' . $date . '", DateExpires = "' . $exp_date . '" WHERE LoginKey = "' . $_SESSION["SSID"] . '";';
                        mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
                        setcookie("SSID", $_SESSION['SSID'], time() + 604800, "/");
                        header("location: homePage.php");
                        
                    } else {
                        
                        $errorMessage = "User already logged in, please sign-out of other device before signing in again.";
                        unset($_SESSION["id"]);
                        unset($_SESSION["username"]);
                        
                    }
                    
                } else { // Create new login session //
                    
                    $sql_query = 'INSERT INTO LOGIN_SESSIONS (LoginKey, ClientIP, ID, DateExpires) VALUES ("' . $_SESSION['SSID'] . '", "' . $_SERVER["REMOTE_ADDR"] . '", "' . $_SESSION["id"] . '", "' . $exp_date . '");';
                    mysqli_query($db, $sql_query) or die("Query Failed: " . mysqli_error($db));
                    setcookie("SSID", $_SESSION['SSID'], time() + 604800, "/");
                    header("location: homePage.php");
                    
                }
                
            }else{
                $errorMessage = "You must validate your registered email address!"; 
                
                unset($_SESSION["id"]);
                unset($_SESSION["name"]);
            }
            
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
