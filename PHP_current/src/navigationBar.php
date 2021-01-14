<?php $db = new mysqli($servername, $username, $password, $dbname); ?>
		
		<div class="navBar">
			<a class="navBarTitle" href="homePage.php">Project Ideas Board</a>
			<!-- if signed in -->
			<?php if ($_SESSION['id']) { ?>
			<div class="dropdown">
				<a class="navBarTab" href="settingsPage.php">Settings</a>
				<div class="dropdown-content" style="right:0;">
					<a class="dropdown-content-item" href="forumPage.php">Forum</a>
					<a class="dropdown-content-item" href="logout.php">Sign-out</a>
				</div>
			</div>
            <?php
                $sqlnotificationcheck = "SELECT * FROM NOTIFICATIONS WHERE NOTIFICATIONS.StudentID=". $_SESSION['id'] . " AND NOTIFICATIONS.NotificationRead=0";
                $resultnotificationcheck = mysqli_query($db, $sqlnotificationcheck) or die('query failed' . $_SESSION['id'] . mysqli_error($db));  
                $numberOfUnread = $resultnotificationcheck->num_rows;
                if($resultnotificationcheck->num_rows == 0){
            ?>
			<a class="navBarTab" href="notificationsPage.php">Notifications</a>
            <?php
                }else{
             ?>
			<a class="navBarTab" href="notificationsPage.php">Notifications ( <?php echo $numberOfUnread; ?> )</a>
			<!-- fix unicode symbol alignment later -->
			<!-- <a class="navBarTab" href="notificationsPage.php">Notifications &#10071;</a> -->
            <?php   
                 mysqli_free_result($resultnotificationcheck);
                } ?>
			<a class="navBarTab" href="inbox.php">
			Inbox
			<?php
			$sqlIUQ = "SELECT * FROM INBOX WHERE INBOX.RecipientID = " . $_SESSION['id'] . " AND INBOX.HasRead = 0";
            $sqlIUResult = mysqli_query($db, $sqlIUQ) or die('query failed' . $_SESSION['id'] . mysqli_error($db));  
            echo '<span style="font-weight:bold;background-color:red;color:white;padding-left:7px;padding-right:7px;">' . $sqlIUResult->num_rows . '</span>';
			?>
			</a>
			<div class="dropdown">
				<a class="navBarTab" href="profilePage.php"><?php echo $_SESSION['username'] . " ";?> Profile</a>
				<div class="dropdown-content">
					<a class="dropdown-content-item" href="profileEdit.php">Edit Profile</a>
					<a class="dropdown-content-item" href="myProjectsPage.php">My Projects</a>
					<a class="dropdown-content-item" href="groupsJoinedPage.php">My Groups</a>
				</div>
			</div>
			<a class="navBarTab" href="postProject.php">New Project</a>
            
			<!-- else if not signed in -->
			<?php } else { ?>
            <a class="navBarTab" href="forumPage.php">Forum</a>
			<a class="navBarTab" href="loginPage.php">Sign-in</a>
			<a class="navBarTab" href="registerPage.php">Sign-up</a>
			<?php } ?>
			<form action="searchResults.php?s=<?php echo htmlspecialchars(urldecode($_GET['search']));?>" method="GET">
      			<input type="text" class="searchTextField" placeholder="Search..." name="search" style="float:left">
				<button type="submit" class= "searchButton" style="float:left">&#128269;</button>
    		</form>
		</div>