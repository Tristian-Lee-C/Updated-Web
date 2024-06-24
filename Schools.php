<!DOCTYPE html>
<?php
	require_once('database.php');
	session_start();
	if(!isset($_SESSION["is_user"]))
	{
		$action = 'login';
	}
	elseif(!isset($_SESSION["is_administator"]))
	{
		$action = 'Home';
	}
	else
		$action = '';

	switch($action){
		case 'login':
			header('Location: http://192.168.2.157/volunteer/Login.php');
			break;
	}

	if(isset($_POST['logOutbutton'])){
		header('Location: http://192.168.2.157/volunteer/Login.php');
		session_destroy();
	}

	if(isset($_POST['logOutbutton'])){
		header('Location: http://192.168.2.157/volunteer/Login.php');
		session_destroy();
	}


	$querySchool = 'SELECT *
					FROM school_list';
	$statementSchool = $db->prepare($querySchool);
	$statementSchool->execute();
	$SchoolMulti = $statementSchool->fetchAll();
	$statementSchool->closeCursor();



?>

<html>
	<head>
  		<title>Home</title>
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="schools_template.css">
		<link rel="stylesheet" href="footer_template.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	</head>

	<body>
		<div class='Notice'>
			<a class='usertag'><?php echo $_SESSION["user"];?></a>
			<a class='dashbetween'> - </a>
			<a class='roletag'><?php echo $_SESSION["user_level"];?><a>
			<form class ="logOut" action="" method="POST"><input type="submit" value="Log Out" name='logOutbutton'></form>
		</div>
		<div id="wrapper">
			<header>
				<div class="header">
					<img src="images/CIS Side Icon.png">
					<h1>Volunteer Portal</h1>
				</div>
			</header>

			<nav>
				<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || isset($_SESSION["is_user"])){?>
				<a class='Home' href="Home.php">Home</a>
				<?php }; ?>
				<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || !isset($_SESSION["is_user"])) {?>
				<a class='Services' href="Services.php">Services</a>
				<?php }; ?>
				<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || !isset($_SESSION["is_user"])) {?>
				<a class='Reports' href="Reports.php">Reports</a>
				<?php }; ?>
				<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || isset($_SESSION["is_user"])) {?>
				<a class='Account' href="Account.php">Account</a>
				<?php }; ?>
			</nav>

			<main>
			<div class='dashboard'>
			<hr></hr><br>
			<div class='subNav'>
					<div class='Settings'><br>
						<a class='SubNavTitle'>Settings</a><br><br>
						&emsp;<a class='linkPage' href='Profile.php'>Profile</a><br><br>
						&emsp;<a class='linkPage' href='Password.php'>Password</a><br><br>
					</div>
					<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || !isset($_SESSION["is_user"])) {?>
					<div class='AdminTools'>
					<a class='SubNavTitle'>Admin Tools</a><br><br>
						<a class='SubTwoNavTitle'>Manage</a><br><br>
						&emsp;<a class='linkPage' href='Staff.php'>Staff</a><br><br>
						&emsp;<a class='linkPage' href='Schools.php'>Schools</a><br><br>
						&emsp;<a class='linkPage' href='serviceTool.php'>Service Codes</a><br><br>
						&emsp;<a class='linkPage' href='Tiers.php'>Service Tiers</a><br><br>
						&emsp;<a class='linkPage'>Volunteer Types</a><br><br>
						&emsp;<a class='linkPage'>Users</a><br><br>
						&emsp;<a class='linkPage'>Delete Services</a><br><br>
					</div>
					<?php }; ?>
				</div>


				<div class='WebGut'>
					<div class='CreateSchoolSect'>
					<form class ="addSchoolButton" action="AddSchoolPU.php" method="POST" id='mainForm'><input type="submit" value="Add" name='addSchools'></form>
					<div class='Scroll'>
					<table class ='school_list'>
							<thead>
								<tr>
									<th>School ID</th>
									<th>School Name</th>
									<th>Disabled/Active</th>
									<th>Action</th>
								</tr>
							</thead>
							<?php foreach ($SchoolMulti as $SchoolSingle): ?>
							<?php 
							$grabIDSchool = $SchoolSingle['schoolID'];
							$queryFilter = 'SELECT delete_fact
											FROM deleted_schools
											WHERE schoolID = :grabIDSchool;';
							$statementFilter = $db->prepare($queryFilter);
							$statementFilter->bindValue(':grabIDSchool', $grabIDSchool);
							$statementFilter->execute();
							$checkQuery = $statementFilter->fetch();
							$statementFilter->closeCursor();
							?>

							<?php if ($checkQuery['delete_fact'] == FALSE){
							?>
							<tbody>
								<td><?php echo $SchoolSingle['schoolID'];?></td>
								<td><?php echo $SchoolSingle['school_name'];?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="schoolID" value="<?php echo $SchoolSingle['schoolID']; ?>">
										<label class="switch">
											<input class="schoolToggle" type="checkbox" name='schoolToggle' <?php if($SchoolSingle['on_off'] == TRUE){?> checked <?php }; ?>>
											<span class="slider round"></span>
										</label>
									</form>
								</td>
								<td>
						
								<?php if (isset($_SESSION["is_administator"])){?>
											<form class ="editSchoolButton" action="editSchoolPU.php" method="POST">
											<input type='hidden' name='schoolIDEdit' value='<?php echo $SchoolSingle['schoolID'];?>'>
											<input type='submit' value='Edit' name='editSchool'>
											</form>
								<?php }; ?>
							
								<?php if (isset($_SESSION["is_administator"])){?>
											<form class ="deleteSchoolButton" action="deleteSchoolPU.php" method="POST">
											<input type='hidden' name='schoolIDDelete' value='<?php echo $SchoolSingle['schoolID'];?>'>
											<input type='submit' value='Delete' name='deleteSchool'>
											</form>
								<?php }; ?></td>
							</tbody>
							<?php }; ?>
							<?php endforeach;?>
						</table>
						</div>
					</div>
				</div>
		</main>
		</div>
	</body>
	<footer>
		<p>Copyright CISHOT &copy; <?php echo date('Y');?></p>
	</footer>
</html>

<script>
function checkBoxAction(event) {
    var checkbox = event.target; // Get the checkbox that triggered the event
    var isChecked = checkbox.checked;
    var schoolID = checkbox.closest('tr').querySelector('input[name="schoolID"]').value; // Get the staffID associated with the checkbox
    console.log('isChecked:', isChecked); // Debugging statement
    console.log('schoolID:', schoolID); // Debugging statement

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Handle response if needed
            console.log(this.responseText);
        }
    };

    // Include staffID in the query string
    xhttp.open("GET", "updateSchoolDB.php?isChecked=" + isChecked + "&schoolID=" + schoolID, true);
    xhttp.send();
}

// Wait for the DOM content to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Find all checkboxes with the class 'staffToggle'
    var checkboxes = document.querySelectorAll('input.schoolToggle');
    
    // Attach the event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
        // Attach the event listener for the 'change' event
        checkbox.addEventListener('change', checkBoxAction);
    });
});
</script>