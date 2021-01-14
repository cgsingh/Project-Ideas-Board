<?php

/*
Group: 22
BTS630
File: myGroupMembersPage.php
- Displays all group members
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
		<?php include('navigationBar.php'); 
            
            $projectID = $_GET["projectid"];
            $sql_query_project = "SELECT * FROM PROJECT WHERE ProjectID=" . $projectID . "";
            $result_project = mysqli_query($db, $sql_query_project) or die('query failed'. mysqli_error($db));
            $row3 = mysqli_fetch_assoc($result_project);
            $projectName = $row3['Title'];
        ?>
        
        
		
		<div class="projectPostContainer">
		<h2 class="subTitle"><?php echo $projectName; ?></h2>
		<!-- a listing similar to reddit -->
		<ul class="projectList" id="projectList">
		<?php
            
            $userID = $_SESSION['id'];
            //Get Project based on ID
           
            
            $sql_query_group = "SELECT * FROM GROUP_LIST WHERE ProjectID=" . $projectID . "";
            $result_group = mysqli_query($db, $sql_query_group) or die('query failed'. mysqli_error($db));
            $row = mysqli_fetch_assoc($result_group);
            $groupID = $row['GroupID'];
            
            //Get All Group Members
            $sql_query_group_members = "SELECT * FROM GROUP_MEMBERS WHERE GroupID=" . $groupID . "";
            $result_group_members = mysqli_query($db, $sql_query_group_members) or die('query failed'. mysqli_error($db));
            $groupmemberids=array();
            
            if($result_group_members->num_rows > 0){
                while($row = $result_group_members->fetch_assoc()){
                    array_push($groupmemberids, $row['StudentID']);
                }
            }
            
            $arrlen=count($groupmemberids);
            
            $groupmembers=array();
                
            for( $i=0; $i<$arrlen; $i++){    
                $sql_query_usernames = "SELECT * FROM USER
                    WHERE StudentID ='" .$groupmemberids[$i]. "'";
                                                                    
                    $result_usernames = mysqli_query($db, $sql_query_usernames) or die('query failed'. mysqli_error($db));     
                                        
                    if($result_usernames->num_rows > 0){
                        while($row2 = $result_usernames->fetch_assoc()){
                            array_push($groupmembers, $row2['Username']);
                        }
                    }
            }
		  
            
            
			for($j=0;$j<$arrlen; $j++){
                    
                    $studentID = $groupmemberids[$j];
                    $usernamer = $groupmembers[$j];
                
                    if($studentID == $userID){
                        
                    }else{
                        
                        echo '<li class="projectItem searchItem">';
                        echo '<a class="aList" href="profilePage.php?id=' . $studentID . '">';				
                        echo '<p class="projTitle">' . urldecode($usernamer) . '</p>';                   
                        echo '</a>';
                        
                        echo '<button class="formBtn"><a style="text-decoration:none;color:#FFFFFF;font-family:"Times New Roman";" href="deleteGroupMember.php?id=' . $studentID . '&gro=' . $groupID . '">DELETE GROUP MEMBER</a></button>';
                        echo '</li>';

                        
                        
                    }      
            }
                
            if($arrlen == 0){
                echo 'No Posts have been created yet!';
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