<?php
	session_start();

	$staffID = filter_input(INPUT_POST,'idHolderStaff');
    $passwordNew = filter_input(INPUT_POST,'passwordNew');
    $passwordValidate = filter_input(INPUT_POST,'passwordValidate');


    require_once('database.php');
	$_SESSION['err_msg'] = '';
    $_SESSION['cpt_msg'] = '';
	$gate = (boolean)True;

	if($passwordNew === $_SESSION['OldPWHolder'] && !empty($passwordValidate) && !empty($passwordNew)){
		$_SESSION['err_msg'] = "Cannot be like the previous password!";
		$gate = (boolean)False;
        header('Location: http://192.168.2.157/volunteer/ResetStaffPW.php');
	}
	elseif(strcmp($passwordNew, $passwordValidate) == True && !empty($passwordNew) && !empty($passwordValidate)){
		$_SESSION['err_msg'] = "Passwords were not identical. Please Re-enter your passwords!";
		$gate = (boolean)False;
        header('Location: http://192.168.2.157/volunteer/ResetStaffPW.php');
	}
    elseif(preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W)[0-9A-Za-z!@#$]{8,30}$/', $passwordNew) == FALSE){
        $_SESSION['err_msg'] = 'Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters';
        $gate = (boolean)False;
        header('Location: http://192.168.2.157/volunteer/ResetStaffPW.php');
    }
	else
	{
		$gate = (boolean)True;
	}



    if($gate === TRUE){
    unset($_SESSION['cpt_msg']);
    unset($_SESSION['err_msg']);
    $hashNewPW = password_hash($passwordNew, PASSWORD_BCRYPT);
    if(!empty($staffID) && !empty($passwordNew)){
        $queryPW = 'UPDATE staff_login
                        SET staff_password=:hashNewPW
                        WHERE staff_ID=:staffID';
        $getPWStatement = $db->prepare($queryPW);
        $getPWStatement->bindValue(':hashNewPW', $hashNewPW);
        $getPWStatement->bindValue(':staffID', $staffID);
        $getPWStatement->execute();
        $getPWStatement->closeCursor();
        $_SESSION['cpt_msg'] = 'Password has been changed';
        unset($_SESSION['sid']);
        header('Location: http://192.168.2.157/volunteer/ResetStaffPW.php');
        exit();
    }
    header('Location: http://192.168.2.157/volunteer/ResetStaffPW.php');
    };
?>