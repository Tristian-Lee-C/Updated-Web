<!DOCTYPE html>
<?php
	require_once('database.php');
	session_start();
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

	$ID = filter_input(INPUT_POST,'ID');
	$firstName = filter_input(INPUT_POST,'firstName');
    $lastName = filter_input(INPUT_POST,'lastName');
    $email = filter_input(INPUT_POST,'Email');
    $phone = filter_input(INPUT_POST,'phone');
	$birthday = filter_input(INPUT_POST,'dobV');
    //optional values//
    $street = filter_input(INPUT_POST,'street');
    $stateAddress = filter_input(INPUT_POST,'state_address');
    $zip = filter_input(INPUT_POST,'zip');
    $county = filter_input(INPUT_POST,'county');
	$city = filter_input(INPUT_POST,'city');

?>
<html>
	<head>
  		<title>Services</title>
		<meta name="viewport" content="width=device-width, initial-scale=.66">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="editprofile_template.css">
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
				<br><a class="editUserText">Edit Volunteer</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='volunteerInformation'>Volunteer's Information</a>
					<a class='cancelButton' href= "Profile.php">Back</a>
					<input class='confirmButton' type="submit" value="Update" name='editAddUser' form='editFormSect'>
					<br><br><hr></hr>
					<form id='editFormSect' action="editprofiledb.php" method="post" class='editForm'>
						<br>
						<div class='formSpace'>
						<div class='columnOne'>
						<label class='first'>First Name:
							<input type='text' name='firstName' value='<?php echo $firstName;?>' required><br></label>
							<br>
						<label class='first'>Last Name:
							<input type='text' name='lastName' value='<?php echo $lastName;?>' required><br></label>
							<br>
						<label class='first'>Email Address:
							<input type='text' name='email' value='<?php echo $email;?>' required><br></label>
							<br>
						<label class='first'>Phone Number:
							<input type='tel' name='phone' minlength='10' maxlength='14' value='<?php echo $phone;?>' required><br></label>
							<br>
							<label class='first'><a class='dateofBirth'>Date of Birth:</a>
							<input type='date' class='birthdaySet' name='birthday' value='<?php echo $birthday;?>' required>
						</label>
						<br><br>
						</div>
						<div class='columnTwo'>
						<label class='second'>Street Address:
							<input type="text" name="street" value='<?php if(empty($street)){ echo NULL;} else{echo $street;};?>'>
						</label>
						<br><br>
						<label class='second'>City:
							<input type="text" name="city" value='<?php if(empty($city)){ echo NULL;} else{echo $city;};?>'>
						</label>
						<br><br>
						<label class='second'>State:
							<input type="text" name="state" value='<?php if(empty($stateAddress)){ echo NULL;} else{echo $stateAddress;};?>'>
						</label>
							<br><br>
						<label class='second'>Zip:
							<input type="text" name="zip" value='<?php if(empty($zip)){ echo NULL;} else{echo $zip;};?>'>
						</label>
						<br><br>
						<label class='second'>County:
							<input type="text" name="county" value='<?php if(empty($county)){ echo NULL;} else{echo $county;};?>'>
						</label>
						<br><br>
					</div>
							<input type='hidden' name='ID' value='<?php echo $ID;?>'>
							<br><br>
							<div>
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