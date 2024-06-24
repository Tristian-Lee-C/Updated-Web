<?php
	session_start();
    require_once('database.php');
	$user_name = filter_input(INPUT_POST,'usernameGet');
	$user_password = filter_input(INPUT_POST,'password');
	$validator = filter_input(INPUT_POST,'validatorPost');


	if(!empty($user_name) && !empty($user_password) && (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]))){
	$query = 'SELECT * FROM staff_login WHERE staff_email=:user_name';
	$statement = $db->prepare($query);
	$statement->bindValue(':user_name', $user_name);
	$statement->execute();
	$row = $statement->fetch();
	$statement->closeCursor();
	if(!empty($row)){
		$hash = $row['staff_password'];
		if(password_verify($user_password, $hash) && $_SESSION["user"] == $user_name) {
			$validator = (boolean)TRUE;
			$_SESSION['UserHolder'] = $user_name;
			$_SESSION['OldPWHolder'] = $user_password;
			$_SESSION['validatorHolder'] = $validator;
			header('Location: http://192.168.2.157/volunteer/ResetPassword.php');
		}
		else{
			header('Location: http://192.168.2.157/volunteer/Password.php');
		};
	
	}
	}
	elseif (!empty($user_name) && !empty($user_password) && !isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){
		$query = 'SELECT * FROM volunteer_login WHERE volunteer_email=:user_name';
		$statement = $db->prepare($query);
		$statement->bindValue(':user_name', $user_name);
		$statement->execute();
		$row = $statement->fetch();
		$statement->closeCursor();
		if(!empty($row)){
			$hash = $row['volunteer_password'];
			if(password_verify($user_password, $hash) && $_SESSION["user"] == $user_name) {
				$validator = (boolean)TRUE;
				$_SESSION['UserHolder'] = $user_name;
				$_SESSION['OldPWHolder'] = $user_password;
				$_SESSION['validatorHolder'] = $validator;
				header('Location: http://192.168.2.157/volunteer/ResetPassword.php');
			}
			else{
				header('Location: http://192.168.2.157/volunteer/Password.php');
			};
		
		}
	}
	else{
		header('Location: http://192.168.2.157/volunteer/Password.php');
	};

?>