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


	$querySCode = 'SELECT *
					FROM service_code';
	$statementSCode = $db->prepare($querySCode);
	$statementSCode->execute();
	$SCodeMulti = $statementSCode->fetchAll();
	$statementSCode->closeCursor();



?>

<html>
	<head>
  		<title>Home</title>
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="serviceTool_template.css">
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
					<div class='CreateSCodeSect'>
					<form class ="addSCodeButton" action="AddSCodePU.php" method="POST" id='mainForm'><input type="submit" value="Add" name='addSCode'></form>
					<div class='Scroll'>
					<table class ='SCode_list'>
							<thead>
								<tr>
									<th>Service Code ID</th>
									<th>Service Code</th>
									<th>Disabled/Active</th>
									<th>Action</th>
								</tr>
							</thead>
							<?php foreach ($SCodeMulti as $SCodeSingle): ?>
							<?php 
							$grabIDSCode = $SCodeSingle['service_codeID'];
							$queryFilter = 'SELECT delete_fact
											FROM deleted_servicecode
											WHERE service_codeID = :grabIDSCode;';
							$statementFilter = $db->prepare($queryFilter);
							$statementFilter->bindValue(':grabIDSCode', $grabIDSCode);
							$statementFilter->execute();
							$checkQuery = $statementFilter->fetch();
							$statementFilter->closeCursor();
							?>

							<?php if ($checkQuery['delete_fact'] == FALSE){
							?>
							<tbody>
								<td><?php echo $SCodeSingle['service_codeID'];?></td>
								<td><?php echo $SCodeSingle['service_code'];?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="SCodeID" value="<?php echo $SCodeSingle['service_codeID']; ?>">
										<label class="switch">
											<input class="SCodeToggle" type="checkbox" name='SCodeToggle' <?php if($SCodeSingle['on_off'] == TRUE){?> checked <?php }; ?>>
											<span class="slider round"></span>
										</label>
									</form>
								</td>
								<td>
						
								<?php if (isset($_SESSION["is_administator"])){?>
											<form class ="editSCodeButton" action="editSCodePU.php" method="POST">
											<input type='hidden' name='SCodeIDEdit' value='<?php echo $SCodeSingle['service_codeID'];?>'>
											<input type='submit' value='Edit' name='editSCode'>
											</form>
								<?php }; ?>
							
								<?php if (isset($_SESSION["is_administator"])){?>
											<form class ="deleteSCodeButton" action="deleteSCodePU.php" method="POST">
											<input type='hidden' name='SCodeIDDelete' value='<?php echo $SCodeSingle['service_codeID'];?>'>
											<input type='submit' value='Delete' name='deleteSCode'>
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
    var SCodeID = checkbox.closest('tr').querySelector('input[name="SCodeID"]').value; // Get the staffID associated with the checkbox
    console.log('isChecked:', isChecked); // Debugging statement
    console.log('SCodeID:', SCodeID); // Debugging statement

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Handle response if needed
            console.log(this.responseText);
        }
    };

    // Include staffID in the query string
    xhttp.open("GET", "updateSCodeDB.php?isChecked=" + isChecked + "&SCodeID=" + SCodeID, true);
    xhttp.send();
}

// Wait for the DOM content to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Find all checkboxes with the class 'staffToggle'
    var checkboxes = document.querySelectorAll('input.SCodeToggle');
    
    // Attach the event listener to each checkbox
    checkboxes.forEach(function(checkbox) {
        // Attach the event listener for the 'change' event
        checkbox.addEventListener('change', checkBoxAction);
    });
});
</script>