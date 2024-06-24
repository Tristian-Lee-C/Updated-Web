<!DOCTYPE html>
<?php
	require_once('database.php');
	session_start();

	$staffID = filter_input(INPUT_POST, 'staffIDDelete');

	if(!isset($_SESSION["is_user"]))
	{
		$action = 'login';
	}
	elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"]))
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


	$queryStaff = 'SELECT *
					FROM staff_name 
					INNER JOIN staff_login ON staff_login.staff_ID = staff_name.staff_ID
					WHERE staff_name.staff_ID = :staffID';
	$statementStaff = $db->prepare($queryStaff);
	$statementStaff->bindValue(':staffID', $staffID);
	$statementStaff->execute();
	$StaffGet = $statementStaff->fetch();
	$statementStaff->closeCursor();

	$staffRoleGet = $StaffGet['user_role'];

	$queryRL = 'SELECT *
	FROM role_list
	WHERE user_role = :staffRoleGet';
	$statementRL = $db->prepare($queryRL);
	$statementRL->bindValue(':staffRoleGet', $staffRoleGet);
	$statementRL->execute();
	$roleLists = $statementRL->fetchAll();
	$statementRL->closeCursor();

	$queryDeleteReason = 'SELECT *
	FROM delete_staff_reason';
	$statementDeleteReason = $db->prepare($queryDeleteReason);
	$statementDeleteReason->execute();
	$DeleteLists = $statementDeleteReason->fetchAll();
	$statementDeleteReason->closeCursor();

?>

<html>
	<head>
  		<title>Home</title>
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="deleteStaff_template.css">
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
				<div class="dashboard">
				<hr></hr>
				<br><a class="deleteStaffText">Delete Staff</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='staffInformation'>Staff's Information</a>

					<a class='cancelButton' href= "Staff.php">Back</a>
					<input class='deleteButton' type="submit" value="Delete" name='deleteStaffUser' form="deleteformSect"/>

					<?php if(!empty($errorCatch)) {?>
						<div class='warningPosition'>
							<div class='warningBox'>
								<a class='message'><?php echo $errorCatch;?> </a>
						</div>
					</div>
					<?php };     $_SESSION['error'] = ''; ?>
					<br><br><hr></hr>
					<form id='deleteformSect' action="deletestaffdb.php" method="post" class='deleteform'>
						<br>
						<div class='formSpace'>
					<div class='columnOne'>
						<br><br>
						<label class='first'>First Name:
							<input type="text" name="firstName" value='<?php echo $StaffGet['first_name'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='first'>Last Name:
							<input type="text" name="lastName" value='<?php echo $StaffGet['last_name'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='first'>Email Address:
							<input type="text" name="email" value='<?php echo $StaffGet['email_address'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='first'>Phone Number:
							<input type="tel" name="phone" minlength='10' maxlength='14' placeholder='(123)456-4562' value='<?php echo $StaffGet['phone_number'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'><a class='dateofBirth'>Date of Birth:</a>
							<input type="date" class='birthdaySet' name='birthday' value='<?php echo $StaffGet['date_of_birth'];?>' disabled readonly>
						</label>
						<br><br>
					</div>

					<div class='columnTwo'>
					<br><br>
						<label class='second'>Street Address:
							<input type="text" name="street" value='<?php echo $StaffGet['street'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>City:
							<input type="text" name="city" value='<?php echo $StaffGet['city'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>State:
							<input type="text" name="state" value='<?php echo $StaffGet['state_address'];?>' disabled readonly>
						</label>
							<br><br>
						<label class='second'>Zip:
							<input type="text" name="zip" value='<?php echo $StaffGet['zip'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>County:
							<input type="text" name="county" value='<?php echo $StaffGet['county'];?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>Role:
							<select name='role_type' disabled readonly>
								<?php foreach ($roleLists as $roleList) : ?>
									<option value='<?php echo $roleList['user_role'];?>'><?php echo $roleList['role_name'];?></option>
								<?php endforeach; ?>
							</select>
						</label>
						<br><br>
					</div>
					</div>
					<div class='deleteGut'>
						<div class="deleteZone">
						<hr></hr>
						<br>
						<a class="deleteUserTextZone">Exit Details</a>
						<br><br>
						<hr></hr>
						</div>
						<br><br>
						<div class='deleteFormRole'>
						<div class='columnThree'>
						<label class='three'>Exit Type:
							<select name='exit_type'>
								<?php foreach ($DeleteLists as $DeleteList) : ?>
									<option value='<?php echo $DeleteList['delete_staff_reason'];?>'><?php echo $DeleteList['delete_staff_reason'];?></option>
								<?php endforeach; ?>
							</select>
						</label>
								</div>
						<div class='columnFour'>
						<br>
							<label class='four'><a class='exitText'>Comment:</a><br>
							<textarea class='paragraphZone' name='exitParagraphComment' cols="60" rows="10"></textarea></label>
							<br><br>
						</div>
								</div>
						</div>
					</div>
						<input type='hidden' name='staffIDDelete' value='<?php echo $StaffGet['staff_ID'];?>'>
					</form>
					</div>
				</div>
				</main>
		</div>
	</body>
	<footer>
		<p>Copyright CISHOT &copy; <?php echo date('Y');?></p>
	</footer>
</html>
