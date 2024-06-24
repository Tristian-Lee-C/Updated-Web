<!DOCTYPE html>
<?php
	require_once('database.php');
	session_start();
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

	if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){
		$account = $_SESSION["user"];
		$queryStaff = 'SELECT *
						FROM staff_login
						WHERE staff_email =:account';
		$staffStatement = $db->prepare($queryStaff);
		$staffStatement->bindValue(':account', $account);
		$staffStatement->execute();
		$staffInfo = $staffStatement->fetch();
		$staffStatement->closeCursor();

		$staffIDGet = $staffInfo['staff_ID'];
		$queryStaffGet = 'SELECT *
						FROM staff_name
						WHERE staff_ID =:staffIDGet';
		$staffGetStatement = $db->prepare($queryStaffGet);
		$staffGetStatement->bindValue(':staffIDGet', $staffIDGet);
		$staffGetStatement->execute();
		$staffInfoRecieved = $staffGetStatement->fetch();
		$staffGetStatement->closeCursor();

		$addressCheck ='';
		if(!empty($staffInfoRecieved['street']))
		{
			$addressCheck .= $staffInfoRecieved['street'];
			$street = $staffInfoRecieved['street'];
		};
		if(!empty($staffInfoRecieved['city']))
		{
			$addressCheck .= ', ';
			$addressCheck .= $staffInfoRecieved['city'];
			$city = $staffInfoRecieved['city'];
		};
		if(!empty($staffInfoRecieved['state_address']))
		{
			$addressCheck .= ' ';
			$addressCheck .= $staffInfoRecieved['state_address'];
			$state_address = $staffInfoRecieved['state_address'];
		};
		if(!empty($staffInfoRecieved['zip']))
		{
			$addressCheck .= ', ';
			$addressCheck .= $staffInfoRecieved['zip'];
			$zip = $staffInfoRecieved['zip'];
		};
		if(!empty($staffInfoRecieved['county']))
		{
			$addressCheck .= ', ';
			$addressCheck .= $staffInfoRecieved['county'];
			$county = $staffInfoRecieved['county'];
		};

	}
	else{
		$userCheck = $_SESSION["user"];
		$query = 'SELECT *
				  FROM volunteer_login
				  WHERE volunteer_email=:userCheck';
		$statement = $db->prepare($query);
		$statement->bindValue(':userCheck', $userCheck);
		$statement->execute();
		$volunteersID = $statement->fetch();
		$volunteerIDCatch = $volunteersID['volunteerID'];
		$statement->closeCursor();

		$queryVInfo = 'SELECT *
						FROM volunteer_name
						WHERE volunteerID =:volunteerIDCatch';
		$volunteerGetStatement = $db->prepare($queryVInfo);
		$volunteerGetStatement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
		$volunteerGetStatement->execute();
		$volunteerInfoRecieved = $volunteerGetStatement->fetch();
		$volunteerGetStatement->closeCursor();
		$addressCheck ='';
		if(!empty($volunteerInfoRecieved['street']))
		{
			$addressCheck .= $volunteerInfoRecieved['street'];
			$street = $volunteerInfoRecieved['street'];
		};
		if(!empty($volunteerInfoRecieved['city']))
		{
			$addressCheck .= ', ';
			$addressCheck .= $volunteerInfoRecieved['city'];
			$city = $volunteerInfoRecieved['city'];
		};
		if(!empty($volunteerInfoRecieved['state_address']))
		{
			$addressCheck .= ' ';
			$addressCheck .= $volunteerInfoRecieved['state_address'];
			$state_address = $volunteerInfoRecieved['state_address'];
		};
		if(!empty($volunteerInfoRecieved['zip']))
		{
			$addressCheck .= ', ';
			$addressCheck .= $volunteerInfoRecieved['zip'];
			$zip = $volunteerInfoRecieved['zip'];
		};
		if(!empty($volunteerInfoRecieved['county']))
		{
			$addressCheck .= ', ';
			$addressCheck .= $volunteerInfoRecieved['county'];
			$county = $volunteerInfoRecieved['county'];
		};
	}



?>
<html>
	<head>
  		<title>Home</title>
		<meta http-equiv="refresh" content="3600">
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="profile_template.css">
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
				<div class='EditSection'>
					<form id='editFormSect' action="EditProfile.php" method="post" class='editForm'>
						<fieldset>
							<legend>Profile:</legend><br>
								<label class='firstName'>First Name:
										<input type="text" name='firstNameShow' value='<?php if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){ $firstName=  $staffInfoRecieved['first_name'];} elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){$firstName= $volunteerInfoRecieved['volunteer_first_name'];}; echo $firstName;?>'disabled><br></label><br>
								<label class='lastName'>Last Name:
										<input type="text" name='lastNameShow' value='<?php if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){ $lastName=  $staffInfoRecieved['last_name'];} elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){$lastName= $volunteerInfoRecieved['volunteer_last_name'];}; echo $lastName;?>'disabled><br></label><br>
								<label class='Email'>Email:
										<input type="text" name='EmailShow' value='<?php if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){ $Email= $staffInfoRecieved['email_address'];} elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){$Email= $volunteerInfoRecieved['volunteer_email'];}; echo $Email;?>'disabled><br></label><br>
								<label class='phone'>Phone:
										<input type="text" name='phoneShow' value='<?php if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){ $phone= $staffInfoRecieved['phone_number'];} elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){$phone= $volunteerInfoRecieved['volunteer_phone'];}; echo $phone;?>'disabled><br></label><br>
								<label class='dobV'>Date of Birth:
										<input type="text" name='dobVShow' value='<?php if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){ $dobV= $staffInfoRecieved['date_of_birth'];} elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){$dobV= $volunteerInfoRecieved['birth_date'];}; echo $dobV;?>'disabled><br></label><br>
								<label class='Address'>Address:
										<input type="text" name='Address' value='<?php if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){ echo $addressCheck;} elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){echo $addressCheck;};?>'disabled><br></label><br>

								<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){?>
										<?php $ID = $staffIDGet;?>
								<?php } elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){?>
										<?php $ID = $volunteerIDCatch;?>
								<?php }; ?>

								<input type='hidden' name='ID' value="<?php echo $ID;?>">
								<input type='hidden' name='firstName' value="<?php echo $firstName;?>">
								<input type='hidden' name='lastName' value="<?php echo $lastName;?>">
								<input type='hidden' name='Email' value="<?php echo $Email;?>">
								<input type='hidden' name='phone' value="<?php echo $phone;?>">
								<input type='hidden' name='dobV' value="<?php echo $dobV;?>">
								<input type='hidden' name='street' value="<?php if(empty($street)){ echo NULL;} else{echo $street;};?>">
								<input type='hidden' name='city' value="<?php if(empty($city)){ echo NULL;} else{echo $city;};?>">
								<input type='hidden' name='state_address' value="<?php if(empty($state_address)){ echo NULL;} else{echo $state_address;};?>">
								<input type='hidden' name='zip' value="<?php if(empty($zip)){ echo NULL;} else{echo $zip;};?>">
								<input type='hidden' name='county' value="<?php if(empty($county)){ echo NULL;} else{echo $county;};?>">

								<input class='confirmButton' type="submit" value="Edit" name='editUser'>
						</fieldset>
					</form>
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