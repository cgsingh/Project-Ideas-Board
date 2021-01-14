<?php

/*
Group: 22
BTS530
File: otherProfile.php
*/

session_start();

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
			
            $userID = $_GET["id"];

            $sql_query = "SELECT STUDENT.FirstName, STUDENT.LastName, STUDENT.Phone, STUDENT.Address, STUDENT.City, STUDENT.Province, STUDENT.Country, STUDENT.PostalCode, STUDENT.Biography, STUDENT.ProfilePic FROM STUDENT INNER JOIN USER ON STUDENT.StudentID='". $userID . "'";

            $sql_query2 = 'SELECT * FROM USER WHERE StudentID="'. $userID. '"LIMIT 1';

			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $row = mysqli_fetch_assoc($result);
    
            $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
            $row2 = mysqli_fetch_assoc($result2);
            
			mysqli_free_result($result);
            mysqli_free_result($result2);
        	
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
		echo "<div class='projectPostContainer'>";
		  echo "<h2 class='subTitle' id='username'></h2>";
		      echo "<ul class='projectList' id='projectList'>";
                echo "<li class='projectItem'>";
                    echo "<br>";             
                    echo "<img class='avatarImg' src='uploadedFiles/profiles/".$row['ProfilePic']."'/>";
                    
                            
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
                                
                                echo "<p class='projTitle'>" . $username . '</p>';
                                echo "<p class='projAuthor'>" . $email . "</p>";
                                //echo "<a class='aList' href='profileEdit.php'>";
                                echo "<p class='projIntro'>Biography:<br/>" . $bio . "</p>";
                                echo "<p class='projIntro'>First Name: " . $firstname . "</p>";
                                echo "<p class='projIntro'>Last Name: " . $lastname . "</p>";
                                echo "<p class='projIntro'>Address: " . $address . "</p>";
                                echo "<p class='projIntro'>City: " . $city . "</p>";
                                echo "<p class='projIntro'>Province: " . $province . "</p>";
                                echo "<p class='projIntro'>Country: " . $country . "</p>";
                                echo "<p class='projIntro'>Postal Code: " . $postalcode . "</p>";
                                echo "<p class='projIntro'>Phone Number: " . $phone . "</p>";
                                
                            
                        echo "</li>";           
                    echo "</ul>";
                    echo "</div>";
                    mysqli_close($db);
                                ?>

		
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
		<script>
		</script>
	</body>
</html>
