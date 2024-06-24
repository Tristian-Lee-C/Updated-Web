<!DOCTYPE html>
<?php
	require_once('database.php');
	$user_name = "";
	$user_password = "";
	$err_msg = "";

	$user_name = filter_input(INPUT_POST, "user_email");
	$user_password = filter_input(INPUT_POST, 'user_password');
	if (isset($_POST['submitLogin']) && empty($_POST['user_email']) && !empty($_POST['user_password'])){
		$err_msg = "Please enter your username";
	}
	if	(isset($_POST['submitLogin']) && !empty($_POST['user_email']) && empty($_POST['user_password'])){
		$err_msg = "Please enter your password";
	}
	if (isset($_POST['submitLogin']) && empty($_POST['user_email']) && empty($_POST['user_password'])){
		$err_msg = "Please enter your username and password";
	}
	if (isset($_POST['submitLogin']) && !empty($_POST['user_email']) && !empty($_POST['user_password'])) 
	{
		$query = 'SELECT * FROM volunteer_login NATURAL JOIN role_list WHERE volunteer_email = :user_name';
		$statement = $db->prepare($query);
		$statement->bindValue(':user_name', $user_name);
		$statement->execute();
		$row = $statement->fetch();
		$statement->closeCursor();
		if(!empty($row)){
			$hash = $row['volunteer_password'];
			if(password_verify($user_password, $hash)) {
				session_start();
				$guest = "Program Volunteer";
				$mod = "Program Manager";
				$admin = "Program Administator";
				$partner = "Partner";
				$_SESSION["user"] = $user_name;

				if($row['role_name'] == 'Guest'){
					$_SESSION["is_user"] = true;
					$_SESSION["user_level"] = $guest;
				}

				if($row['role_name'] == 'Moderator'){
					$_SESSION["is_user"] = true;
					$_SESSION["is_moderator"] = true;
					$_SESSION["user_level"] = $mod;
				}

				if($row['role_name'] == 'Admin'){
					$_SESSION["is_user"] = true;
					$_SESSION["is_moderator"] = true;
					$_SESSION["is_administator"] = true;
					$_SESSION["user_level"] = $admin;
				}

				if($row['role_name'] == 'Baylor'){
					$_SESSION["is_user"] = true;
					$_SESSION["user_level"] = $partner;
				}
				header('Location: http://192.168.2.157/volunteer/Home.php');
			}
			else
				$err_msg = "Incorrect username/password";
				$user_name = "";
				$user_password = "";
				#header('Location: http://192.168.2.157/volunteer/Login.php');
		}
			$queryST = 'SELECT * FROM staff_login NATURAL JOIN role_list WHERE staff_email = :user_name';
			$statementST = $db->prepare($queryST);
			$statementST->bindValue(':user_name', $user_name);
			$statementST->execute();
			$rowST = $statementST->fetch();
			$statementST->closeCursor();
			if(!empty($rowST)){
				$hash = $rowST['staff_password'];
				if(password_verify($user_password, $hash) && $rowST['on_off'] == TRUE) {
					session_start();
					$guest = "Program Volunteer";
					$mod = "Program Manager";
					$admin = "Program Administator";
					$partner = "Partner";
					$_SESSION["user"] = $user_name;
	
					if($rowST['role_name'] == 'Guest'){
						$_SESSION["is_user"] = true;
						$_SESSION["user_level"] = $guest;
					}
	
					if($rowST['role_name'] == 'Moderator'){
						$_SESSION["is_user"] = true;
						$_SESSION["is_moderator"] = true;
						$_SESSION["user_level"] = $mod;
					}
	
					if($rowST['role_name'] == 'Admin'){
						$_SESSION["is_user"] = true;
						$_SESSION["is_moderator"] = true;
						$_SESSION["is_administator"] = true;
						$_SESSION["user_level"] = $admin;
					}
	
					if($rowST['role_name'] == 'Baylor'){
						$_SESSION["is_user"] = true;
						$_SESSION["user_level"] = $partner;
					}
					header('Location: http://192.168.2.157/volunteer/Home.php');
				}
				elseif($rowST['on_off'] == FALSE){
					$err_msg = "User's account has been disabled";
					$user_name = "";
					$user_password = "";
				}
				else
				{
					$err_msg = "Incorrect username/password";
					$user_name = "";
					$user_password = "";
					#header('Location: http://192.168.2.157/volunteer/Login.php');
				}
		}
		else
			$user_name = "";
			$user_password = "";
			if($err_msg == ''){
			$err_msg = "Incorrect username/password";
			}
	}
?>

<html>
	<head>
  		<title>Log In</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="login_template.css">
		<link rel="stylesheet" href="footer_template.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	</head>

	<body>
		<div id="wrapper">
			<header>
				<div class="header">
					<img src="images/CIS Side Icon.png">
					<h1>Volunteer Portal</h1>
				</div>
			</header>

			<nav>
			</nav>

			<main>
				<p class='welcome'>Welcome to CISHOT Volunteer Portal!</p>
				<div class="intro">
					<p class='login'>Login Page</p>
					<form action="" method="Post" id="login_form">
						<input type="hidden" name="action" value="login">
						
						<?php if(!empty($err_msg)) {?>
							<div class='warningBox'>
								<a class='message'><?php echo $err_msg;?> </a></br>
							</div>
						<?php }; ?>

						<a class='emailspacing'><label class ='email'>Username:</label>&nbsp;
						<input type="email" name="user_email" size="35" value="<?=htmlspecialchars($user_name, ENT_QUOTES)?>" required><br><br></a>

						<a class='passwordspacing'><label class ='password'>Password:</label>&nbsp;
						<input type="password" name="user_password" size="35" value="<?=htmlspecialchars($user_password, ENT_QUOTES)?>" required><br><br></a>


						<a class='submitButton'><input type="submit" value="Login" name='submitLogin' class="loginButton"></a>
					</form>
				</div>
			</main>
		</div>
	</body>
	<footer>
		<p class='copyright'>Copyright CISHOT &copy; <?php echo date('Y');?></p>
	</footer>
</html>