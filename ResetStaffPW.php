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

	$staffID = filter_input(INPUT_POST, 'staffIDReset');
	$PWNew = filter_input(INPUT_POST, 'passwordNew');
	$PWCheck = filter_input(INPUT_POST, 'passwordValidate');

    if(!empty($staffID)){
		$_SESSION['sid'] = $staffID;
	}
    elseif(empty($staffID) && empty($_SESSION['cpt_msg'])){
        $staffID = $_SESSION['sid'];
    }

?>
<html>
	<head>
  		<title>Home</title>
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="resetstaffpw_template.css">
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
						&emsp;<a class='linkPage'>Service Tiers</a><br><br>
						&emsp;<a class='linkPage'>Volunteer Types</a><br><br>
						&emsp;<a class='linkPage'>Users</a><br><br>
						&emsp;<a class='linkPage'>Delete Services</a><br><br>
					</div>
					<?php }; ?>
					</div>


			<div class='WebGut'>
				<div class='resetPasswordSection'>
					<form id='resetPasswordSect' action="resetstaffpwdb.php" method="post" class='resetPassword'>
						<fieldset>
 							<legend> Password Reset:</legend><br>
								<div class='fieldSetTextBox'>

								<?php if(!empty($_SESSION['err_msg'])) {?>
									<div class='warningBox'>
										<a class='message'><?php if(empty($_SESSION['err_msg'])){ echo Null;} else{ echo $_SESSION['err_msg']; 	$_SESSION['err_msg'] = '';};?> </a></br>
										<?php }; ?>
									</div>
								<?php if(!empty($_SESSION['cpt_msg'])) {?>
									<div class='completeBox'>
										<a class='messageComplete'><?php if(empty($_SESSION['cpt_msg'])){ echo Null;} else{ echo $_SESSION['cpt_msg']; 	$_SESSION['cpt_msg'] = '';};?> </a></br>
									</div>
								<?php }; ?>
								<label class='newPassword'>New Password:
									<input type="password" name='passwordNew' value='' required><br>
								</label><br>
								<label class='PasswordSlot'>Re-enter New Password:
									<input type="password" name='passwordValidate' value='' required><br>
								</label><br>
									<input type='hidden' name='idHolderStaff' value='<?php echo $staffID;?>'>
								<input class='confirmButton' type="submit" value="Reset" name='editUser'>
								</div>
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
