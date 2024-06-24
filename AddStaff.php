<!DOCTYPE html>
<?php
	require_once('database.php');
	session_start();

	if(!empty($_SESSION['error'])){
	$errorCatch = $_SESSION['error'];
	}
	elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"]))
	{
		$action = 'Home';
	}
	if(!isset($_SESSION["is_user"]))
	{
		$action = 'login';
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

    $_SESSION['passwordMemory'] = '';
    $_SESSION['rememberstaffID'] = '';
    $_SESSION['rememberemail'] = '';

	$adminRole = "Admin";
	$modRole = "Moderator";

	$queryRL = 'SELECT *
				FROM role_list
				WHERE role_name=:adminRole OR role_name=:modRole';
	$statementRL = $db->prepare($queryRL);
	$statementRL->bindValue(':adminRole', $adminRole);
	$statementRL->bindValue(':modRole', $modRole);
	$statementRL->execute();
	$roleLists = $statementRL->fetchAll();
	$statementRL->closeCursor();

?>
<html>
	<head>
  		<title>Services</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="addstaff_template.css">
		<link rel="stylesheet" href="footer_template.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
				<a class='Home' href="Home.php">Home</a>
				<a class='Services' href="Services.php">Services</a>
				<a class='Reports' href="Reports.php">Reports</a>
				<a class='Account' href="Account.php">Account</a>
			</nav>

			<main>
				<div class="dashboard">
				<hr></hr>
				<br><a class="addStaffText">Add Staff</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='staffInformation'>Staff's Information</a>

					<a class='cancelButton' href= "Staff.php">Back</a>
					<input class='addButton' type="submit" value="Add" name='addAddStaff' form="addformSect"/>

					<?php if(!empty($errorCatch)) {?>
						<div class='warningPosition'>
							<div class='warningBox'>
								<a class='message'><?php echo $errorCatch;?> </a>
						</div>
					</div>
					<?php };     $_SESSION['error'] = ''; ?>
					<br><br><hr></hr>
					<form id='addformSect' action="addstaffdb.php" method="post" class='addform'>
						<br>
						<div class='formSpace'>
					<div class='columnOne'>
						<br><br>
						<label class='first'>First Name:
							<input type="text" name="firstName" required>
						</label>
						<br><br>
						<label class='first'>Last Name:
							<input type="text" name="lastName"required>
						</label>
						<br><br>
						<label class='first'>Email Address:
							<input type="text" name="email" required>
						</label>
						<br><br>
						<label class='first'>Phone Number:
							<input type="tel" name="phone" minlength='10' maxlength='14' placeholder='(123)456-4562'required>
						</label>
						<br><br>
						<label class='second'><a class='dateofBirth'>Date of Birth:</a>
							<input type="date" class='birthdaySet' name='birthday' required>
						</label>
						<br><br>
					</div>

					<div class='columnTwo'>
					<br><br>
						<label class='second'>Street Address:
							<input type="text" name="street">
						</label>
						<br><br>
						<label class='second'>City:
							<input type="text" name="city">
						</label>
						<br><br>
						<label class='second'>State:
							<input type="text" name="state">
						</label>
							<br><br>
						<label class='second'>Zip:
							<input type="text" name="zip">
						</label>
						<br><br>
						<label class='second'>County:
							<input type="text" name="county">
						</label>
						<br><br>
						<label class='second'>Role:
							<select name='role_type' required>
								<?php foreach ($roleLists as $roleList) : ?>
									<option value='<?php echo $roleList['role_name'];?>'><?php echo $roleList['role_name'];?></option>
								<?php endforeach; ?>
							</select>
						</label>
						<br><br>
					</div>
					</div>
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