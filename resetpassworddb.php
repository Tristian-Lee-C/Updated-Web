<?php
	session_start();

	$userName = filter_input(INPUT_POST,'userNameHolder');
    $passwordOld = filter_input(INPUT_POST,'userPWOldHolder');
    $passwordNew = filter_input(INPUT_POST,'passwordNew');
    $passwordValidate = filter_input(INPUT_POST,'passwordValidate');


    require_once('database.php');
	$_SESSION['err_msg'] = '';
	$gate = (boolean)True;

	if($passwordNew === $_SESSION['OldPWHolder'] && !empty($passwordValidate) && !empty($passwordNew)){
		$_SESSION['err_msg'] = "Cannot be like the previous password!";
		$gate = (boolean)False;
        header('Location: http://192.168.2.157/volunteer/ResetPassword.php');
	}
	elseif(strcmp($passwordNew, $passwordValidate) == True && !empty($passwordNew) && !empty($passwordValidate)){
		$_SESSION['err_msg'] = "Passwords were not identical. Please Re-enter your passwords!";
		$gate = (boolean)False;
        header('Location: http://192.168.2.157/volunteer/ResetPassword.php');
	}
    elseif(preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W)[0-9A-Za-z!@#$]{8,30}$/', $passwordNew) == FALSE){
        $_SESSION['err_msg'] = 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters';
        $gate = (boolean)False;
        header('Location: http://192.168.2.157/volunteer/ResetPassword.php');
    }
	else
	{
		$gate = (boolean)True;
	}



    if($gate === TRUE){
    unset($_SESSION['err_msg']);
    unset($_SESSION['UserHolder']);
    unset($_SESSION['OldPWHolder']);
    unset($_SESSION['validatorHolder']);
    $hashNewPW = password_hash($passwordNew, PASSWORD_BCRYPT);
    if(!empty($user_name) && !empty($user_password) && isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){
        $queryUser = 'SELECT *
                        FROM staff_login
                        WHERE staff_email=:userName';
        $getUserStatement = $db->prepare($queryUser);
        $getUserStatement->bindValue(':userName', $userName);
        $getUserStatement->execute();
        $PasswordLists = $getUserStatement->fetch();
        $getUserStatement->closeCursor();

        $hashOldPW = $PasswordLists['staff_password'];

        if(password_verify($passwordOld, $hashOldPW)) {
        $queryPW = 'UPDATE staff_login
                        SET staff_password=:hashNewPW
                        WHERE staff_email=:userName AND staff_password=:hashOldPW';
        $getPWStatement = $db->prepare($queryPW);
        $getPWStatement->bindValue(':hashNewPW', $hashNewPW);
        $getPWStatement->bindValue(':userName', $userName);
        $getPWStatement->bindValue(':hashOldPW', $hashOldPW);
        $getPWStatement->execute();
        $getPWStatement->closeCursor();
        };
        header('Location: http://192.168.2.157/volunteer/Profile.php');
        exit();
    }
    elseif(!empty($user_name) && !empty($user_password) && !isset($_SESSION["is_administator"]) || !isset($_SESSION["is_moderator"]) || isset($_SESSION["is_user"])){
                $queryUser = 'SELECT *
                FROM volunteer_login
                WHERE volunteer_email=:userName';
        $getUserStatement = $db->prepare($queryUser);
        $getUserStatement->bindValue(':userName', $userName);
        $getUserStatement->execute();
        $PasswordLists = $getUserStatement->fetch();
        $getUserStatement->closeCursor();

        $hashOldPW = $PasswordLists['volunteer_password'];

        if(password_verify($passwordOld, $hashOldPW)) {
        $queryPW = 'UPDATE volunteer_login
                SET volunteer_password=:hashNewPW
                WHERE volunteer_email=:userName AND volunteer_password=:hashOldPW';
        $getPWStatement = $db->prepare($queryPW);
        $getPWStatement->bindValue(':hashNewPW', $hashNewPW);
        $getPWStatement->bindValue(':userName', $userName);
        $getPWStatement->bindValue(':hashOldPW', $hashOldPW);
        $getPWStatement->execute();
        $getPWStatement->closeCursor();
        };
        header('Location: http://192.168.2.157/volunteer/Profile.php');
        exit();
    };
    header('Location: http://192.168.2.157/volunteer/ResetPassword.php');
    };
?>