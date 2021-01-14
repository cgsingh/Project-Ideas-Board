<?php

/*
Group: 22
BTS630
File: notificationsPage.php
*/

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
<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/home.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		
		<div class="projectPostContainer">
            <h2 class="subTitle">Notifications</h2>
            <ul class="projectList" id="projectList">
                <?php
                $projectids=array();
                $notificationDates=array();
                $notificationreads=array();
                $userID = $_SESSION['id'];
                $notifications=array();
                $notificationids=array();
                
                $sql_query = "SELECT * FROM NOTIFICATIONS WHERE StudentID='". $userID . "' ORDER BY NotificationDate DESC";
                $result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
                
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        array_push($notificationDates, $row['NotificationDate']);
                        array_push($notifications, $row['Notification']);
                        array_push($projectids, $row['ProjectID']);
                        array_push($notificationids, $row['NotificationID']);
                        array_push($notificationreads, $row['NotificationRead']);
                    }
                }
                                
                $arrlen=count($notificationids);
                
                if($arrlen == 0){
                    echo '<li class="projectItem searchItem">';
                    echo '<p class="projTitle">You have no new notifications!</p>';
                    echo '</li>';
                }else{                   
                    for($j=0;$j<sizeof($notificationids); $j++){
                    
                        $projectID= $projectids[$j];
                        $notificationID= $notificationids[$j];
                        $notificationDate = $notificationDates[$j];
                        $notification = $notifications[$j];
                        $notificationRead = $notificationreads[$j];
                        
                        echo '<li class="projectItem searchItem">';
                        echo '<a class="aList" href="projectDetails.php?id=' . $projectID . '">';
                        echo '<p class="projTitle">' . urldecode($notification) . '</p>';
                        
                        if($notificationRead == 0){
                            echo '<span style="font-size:50px;">&#9733;</span>';
                            $sqlupdatenotification = "UPDATE NOTIFICATIONS SET NotificationRead=1 WHERE StudentID='".$userID."'"; 
                            $updatenotificationcheck = mysqli_query($db, $sqlupdatenotification) or die('query failed'. mysqli_error($db));
                            mysqli_free_result($sqlupdatenotification);
                        }
                        
                        $date = date_create($notificationDate);
                        echo '<p class="projDate">' . date_format($date, "F j, Y") . '</p>';
                        echo '<p class="projEdit"><button class="formBtn"><a style="text-decoration:none;color:#FFFFFF;font-family:"Times New Roman";" href="deleteNotification.php?notificationid=' . $notificationID . '">Delete Notification</a></button><br></p>';
                        echo '</a></li>';
                             
				    }
                }
  
                mysqli_free_result($result);
        		mysqli_close($db);
                ?>
            </ul>
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
	</body>
</html>