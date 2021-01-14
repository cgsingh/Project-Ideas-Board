<?php

/*
Group: 22
BTS530
File: profilePage.php
- Displays the user's profile
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


<?php	
			if ($_GET['id'])
			{
				$userID = $_GET['id'];
			}
            else
			{
				//$sql_query2 = 'SELECT * FROM USER INNER JOIN STUDENT ON USER.StudentID=STUDENT.StudentID ';
				$userID = $_SESSION['id'];
			}

            $sql_query = "SELECT STUDENT.StudentID, STUDENT.FirstName, STUDENT.LastName, STUDENT.Phone, STUDENT.Address, STUDENT.City, STUDENT.Province, STUDENT.Country, STUDENT.PostalCode, STUDENT.Biography, STUDENT.ProfilePic FROM STUDENT INNER JOIN USER ON STUDENT.StudentID='". $userID . "'";

            $sql_query2 = 'SELECT * FROM USER WHERE StudentID="'. $userID. '"LIMIT 1';

			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $row = mysqli_fetch_assoc($result);
    
            $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
            $row2 = mysqli_fetch_assoc($result2);
            
			mysqli_free_result($result);
            mysqli_free_result($result2);
            //mysqli_close($db);
    
        	
		?>
<html>
	<head>
        <link rel="stylesheet" type="text/css" href="css/home.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
		
		<?php
		$username = $row2['Username'];
        $email = $row2['Email'];
        $firstname = $row['FirstName'];
        $lastname = $row['LastName'];
        $address = $row['Address'];
        $city = $row['City'];
        $province = $row['Province'];
        $country = $row['Country'];
        $postalcode = $row['PostalCode'];
        $phone = $row['Phone'];
        $bio = $row['Biography'];
		$profileId = $row['StudentID'];
		?>
		
		<div style="margin-top:50px;margin-left:10px;width:250px;text-align:center;float:left;">
		<hr>
		<?php
		echo "<img style='width:250px;height:250px;border-radius:50%;' class='avatarImg' src='uploadedFiles/profiles/".$row['ProfilePic']."'/>";
		echo "<h2 style='text-align:center;font-family:\"Times New Roman\";font-size:30px;'>" . $firstname . " " . $lastname . "</h2>";
		echo "<p style='margin-top:-20px;text-align:center;font-family:\"Times New Roman\";font-size:20px;'>@" . $username . "</p>";
		echo "<p style='margin-top:-10px;text-align:center;font-family:\"Times New Roman\";font-size:15px;'>" . $city . ", " . strtoupper(substr($province, 0, 2)) . " " . substr($postalcode, 0, 3) . " " . substr($postalcode, 3, 3) . "</p>";
		echo "<p style='margin-top:-5px;text-align:center;font-family:\"Times New Roman\";font-size:15px;'>" . $phone . "</p>";
		?>
		<hr>
		<button class="formBtn" onclick="location.href='composeMessage.php?id=<?php echo $_GET['id']; ?>'" style="width:250px;border:1px solid black;" <?php if ($_SESSION['id'] == $profileId) { echo 'disabled'; }?>>✉ Message</button>
		</div>
		
		<div style="margin-top:50px;margin-left:10px;text-align:center;float:left;width:calc(100% - 280px);">
		<hr>
		<?php
		echo "<h2 style='text-align:center;font-family:\"Times New Roman\";font-size:30px;'>Biography</h2>";
		echo "<p style='margin-top:-20px;text-align:center;font-family:\"Times New Roman\";font-size:20px;'>" . $bio . "</p>";
		?>
		<hr>
		
		<div style="text-align:center;display:table;margin:auto;border-spacing:5px;">
		
		<?php
			$sql_query = "SELECT * FROM PROJECT WHERE StudentID = " . $profileId;

			$resultPosts = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $numPosts = $resultPosts->num_rows;
			
			$sql_query2 = "SELECT * FROM COMMENTS WHERE StudentID = " . $profileId;

			$resultComments = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
            $numComments = $resultComments->num_rows;
		?>
		
		<div style="text-align:center;border:1px solid black;width:150px;display:table-cell;height:100px;vertical-align:middle;background-color:#758ab6;">
		<h2 style="text-align:center;font-family:'Times New Roman';font-size:25px;">Total<br/>Projects</h2>
		<?php echo "<p style='margin-top:-20px;text-align:center;font-family:\"Times New Roman\";font-size:25px;'>" . $numPosts . "</p>";?>
		</div>
		
		<div style="text-align:center;border:1px solid black;width:150px;display:table-cell;height:100px;vertical-align:middle;background-color:#758ab6;">
		<h2 style="text-align:center;font-family:'Times New Roman';font-size:25px;">Total Comments</h2>
		<?php echo "<p style='margin-top:-20px;text-align:center;font-family:\"Times New Roman\";font-size:25px;'>" . $numComments . "</p>";?>
		</div>
		
		</div>
		<hr>
		
		<?php
		echo "<h2 style='text-align:center;font-family:\"Times New Roman\";font-size:30px;'>Recent Activity</h2>";
		
		$sql_query = "SELECT PROJECT.Title, PROJECT.DateCreated, PROJECT.ProjectID FROM PROJECT WHERE StudentID = " . $profileId . " ORDER BY DateCreated DESC";

		$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				echo "<p style='border:1px solid black;margin-top:-10px;text-align:center;font-family:\"Times New Roman\";font-size:20px;background-color:#758ab6'><a style='text-decoration:none;color:#000000;' href='projectDetails.php?id=" . $row['ProjectID'] . "'>" . $row['Title'] . ' | ' . $row['DateCreated'] . "</a></p>";
			}
		}
		else
		{
			echo "<p style='border:1px solid black;margin-top:-10px;text-align:center;font-family:\"Times New Roman\";font-size:20px;background-color:#758ab6'>No Projects Yet.</p>";
		}
		?>
		
		<hr>
		<br/><br/>
		
		</div>
		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
        
        
	</body>
</html>   
		
