
<div class="navBar">
<a class="navBarTitle" href="adminHomePage.php">Project Ideas Board</a>
<!-- if signed in -->
<?php if ($_SESSION['id']) { ?>
<div class="dropdown">
<a class="navBarTab" href="settingsPage.php">Settings</a>
<div class="dropdown-content" style="right:0;">
<a class="dropdown-content-item" href="logout.php">Sign-out</a>
</div>
</div>

<a class="navBarTab" href="adminRequestPage.php">
Requests
<?php
    //adminProjRequests.php to store the requests
    //
    $sqlIUQ = "SELECT * FROM ADMINPROJ_REQUEST WHERE AdminID = " . $_SESSION['id'] . " AND HasRead = 0";
    $sqlIUResult = mysqli_query($db, $sqlIUQ) or die('query failed' . $_SESSION['id'] . mysqli_error($db));
    echo '<span style="font-weight:bold;background-color:red;color:white;padding-left:7px;padding-right:7px;">' . $sqlIUResult->num_rows . '</span>';
    ?>
</a>
<a class="navBarTab" href="adminProjects.php"><?php echo $_SESSION['username'] . " ";?>'s Projects</a>
<a class="navBarTab" href="adminCreateProj.php">Create Project</a>

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
