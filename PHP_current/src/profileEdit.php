<?php 

/*
Group: 22
BTS530
File: profileEdit.php
*/

include('editProfile.php'); 

?>
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

?>


<?php	
			
            //$sql_query2 = 'SELECT * FROM USER INNER JOIN STUDENT ON USER.StudentID=STUDENT.StudentID ';
            $userID = $_SESSION['id'];

            $sql_query = "SELECT STUDENT.FirstName, STUDENT.LastName, STUDENT.Phone, STUDENT.Address, STUDENT.City, STUDENT.Province, STUDENT.Country, STUDENT.PostalCode, STUDENT.Biography FROM STUDENT INNER JOIN USER ON STUDENT.StudentID='". $userID . "'";

            $sql_query2 = 'SELECT * FROM USER WHERE StudentID="'. $userID. '"LIMIT 1';

			$result = mysqli_query($db, $sql_query) or die('query failed'. mysqli_error($db));
            $row = mysqli_fetch_assoc($result);
    
            $result2 = mysqli_query($db, $sql_query2) or die('query failed'. mysqli_error($db));
            $row2 = mysqli_fetch_assoc($result2);
            
			mysqli_free_result($result);
            mysqli_free_result($result2);
        	mysqli_close($db);

            
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
		?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/register.css" />
		<link rel="stylesheet" type="text/css" href="css/searchBar.css" />
		<link rel="stylesheet" type="text/css" href="css/navigationBar.css" />
	</head>
	<body>
		<?php include('navigationBar.php'); ?>
        
		<div class="formContainer" style="margin-top: 300px;">
            
			<form class="formStyle" method="post" action="profileEdit.php" enctype="multipart/form-data">
                
			<h2 class="formTitle">Edit Profile</h2>
                
            <p class="formText">First name:</p>
			<input type="text" class="formInputField" name="firstname" value='<?php echo $firstname;?>' required/>
                
			<p class="formText">Last name:</p>
			<input type="text" class="formInputField" name="lastname" value='<?php echo $lastname;?>' required/>
                
            <p class="formText">Address:</p>
			<input type="text" class="formInputField" name="address" value='<?php echo $address;?>' required/>
                
			<p class="formText">City:</p>
			<input type="text" class="formInputField" name="city" value='<?php echo $city;?>' required/>
                
			<p class="formText">Province:</p>     
			<input type="text" class="formInputField" name="province" value='<?php echo $province;?>' required/><br/>
                
            <p class="formText">Country:</p>     
			<input type="text" class="formInputField" name="country" value='<?php echo $country;?>' required/><br/>
                
            <p class="formText">Postal Code:</p>
			<input type="text" class="formInputField" name="postalcode" value='<?php echo $postalcode;?>' required/>
                
			<p class="formText">Phone Number:</p>
			<input type="tel" class="formInputField" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" value='<?php echo $phone;?>' required/><br/>
            <span>Format: XXX-XXX-XXXX</span>
                                 
			<p class="formText">Biography:</p>
			<textarea class="formInputField" name="bioField" rows="4" cols="50" ><?php echo $bio;?></textarea><br/>

            <br/><input  type="file" name="profilePic" /><br/>
            <button class="formBtn formSubmit" type="submit" name="edit_profile">Submit</button>
            <button class="formBtn formSubmit" type="button" name="submitted" value="Cancel" onClick="window.location='profilePage.php';">Cancel</button>
            <?php include('errors.php'); ?>      
            <br/><br/>
			</form>
		</div>
		<div class="footer">
		<span class="footerNote">BTS530 - Group 22 - Chipemba Bwacha, Matthew Rajevski, Johann Aleman, Christopher Singh</span>
		</div>
	</body>
</html>
