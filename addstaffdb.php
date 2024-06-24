<?php
    session_start();
    $_SESSION['error'] = '';
    $firstName = filter_input(INPUT_POST,'firstName');
    $lastName = filter_input(INPUT_POST,'lastName');
    $email = filter_input(INPUT_POST,'email');
    $phoneRaw = filter_input(INPUT_POST,'phone');
    $phone = preg_replace('/[^0-9]/',"", $phoneRaw);
    $birthday = filter_input(INPUT_POST,'birthday');
    //optional values//
    $street = filter_input(INPUT_POST,'street');
    $city = filter_input(INPUT_POST,'city');
    $stateAddress = filter_input(INPUT_POST,'state');
    $zip = filter_input(INPUT_POST,'zip');
    $county = filter_input(INPUT_POST,'county');
    $roleName = filter_input(INPUT_POST, 'role_type');
    $staffInfo = $_SESSION["user"];


    require_once('database.php');

    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    $generateRandomPassword = random_str(10);
    if(empty($_SESSION['passwordMemory'])){
    $_SESSION['passwordMemory']= $generateRandomPassword;
    };
    $generateHashRandomPassword = password_hash($generateRandomPassword, PASSWORD_BCRYPT);
    $gateKeyOne = FALSE;
    $gateKeyTwo = FALSE;

    $queryStaffCheck='SELECT *
            FROM staff_name
            WHERE email_address=:email';
    $statementStaffCheck = $db->prepare($queryStaffCheck);
    $statementStaffCheck->bindValue(':email', $email);
    $statementStaffCheck->execute();
    $staffCheckResultsOne = $statementStaffCheck->fetch();
    $statementStaffCheck->closeCursor();
    if(empty($staffCheckResultsOne)){
        $gateKeyOne = TRUE;
    }

    $queryStaffCheck='SELECT *
                        FROM staff_name
                        WHERE first_name=:firstName AND last_name=:lastName';
    $statementStaffCheck = $db->prepare($queryStaffCheck);
    $statementStaffCheck->bindValue(':firstName', $firstName);
    $statementStaffCheck->bindValue(':lastName', $lastName);
    $statementStaffCheck->execute();
    $staffCheckResultsTwo = $statementStaffCheck->fetch();
    $statementStaffCheck->closeCursor();
    if(empty($staffCheckResultsTwo)){
        $gateKeyTwo = TRUE;
    }

    if($gateKeyOne == TRUE && $gateKeyTwo == TRUE){
        $queryCreateStaff = 'INSERT INTO staff_name
                            (first_name, last_name, email_address, phone_number, date_of_birth, street, state_address, zip, county, city)
                            VALUES
                            (:firstName, :lastName, :email, :phone, :birthday, :street, :city, :stateAddress, :zip, :county)';
        $statementCreateStaff = $db->prepare($queryCreateStaff);
        $statementCreateStaff->bindValue(':firstName', $firstName);
        $statementCreateStaff->bindValue(':lastName', $lastName);
        $statementCreateStaff->bindValue(':email', $email);
        $statementCreateStaff->bindValue(':phone', $phone);
        $statementCreateStaff->bindValue(':birthday', $birthday);
        $statementCreateStaff->bindValue(':street', $street);
        $statementCreateStaff->bindValue(':city', $city);
        $statementCreateStaff->bindValue(':stateAddress', $stateAddress);
        $statementCreateStaff->bindValue(':zip', $zip);
        $statementCreateStaff->bindValue(':county', $county);
        $statementCreateStaff->execute();
        $statementCreateStaff->closeCursor();

        $queryGetStaff='SELECT *
        FROM staff_name
        WHERE first_name=:firstName AND last_name=:lastName AND email_address=:email';
        $statementGetStaff = $db->prepare($queryGetStaff);
        $statementGetStaff->bindValue(':firstName', $firstName);
        $statementGetStaff->bindValue(':lastName', $lastName);
        $statementGetStaff->bindValue(':email', $email);
        $statementGetStaff->execute();
        $getStaffID = $statementGetStaff->fetch();
        $statementGetStaff->closeCursor();

        $staffID = $getStaffID['staff_ID'];
        if(empty($_SESSION['rememberstaffID']) && empty($_SESSION['rememberemail'])){
            $_SESSION['rememberstaffID'] = $staffID;
            $_SESSION['rememberemail'] = $email;
        };

        $getRoleID = 'SELECT *
                        FROM role_list
                        WHERE role_name =:roleName';
        $statementGetRole = $db->prepare($getRoleID);
        $statementGetRole->bindValue(':roleName', $roleName);
        $statementGetRole->execute();
        $getRoleID = $statementGetRole->fetch();
        $statementGetRole->closeCursor();

        $roleID = $getRoleID['user_role'];
        if(empty($rememberroleID)){
            $rememberroleID = $roleID;
        };


        $queryCreateStaff = 'INSERT INTO staff_login
                            (staff_email, staff_password, user_role, staff_ID)
                            VALUES
                            (:email, :generateRandomPassword, :roleID, :staffID)';
        $statementCreateStaff = $db->prepare($queryCreateStaff);
        $statementCreateStaff->bindValue(':email', $email);
        $statementCreateStaff->bindValue(':generateRandomPassword', $generateHashRandomPassword);
        $statementCreateStaff->bindValue(':roleID', $roleID);
        $statementCreateStaff->bindValue(':staffID', $staffID);
        $statementCreateStaff->execute();
        $statementCreateStaff->closeCursor();

        $queryDeleteStaffSet = 'INSERT INTO deleted_staff
                                (staff_ID, user_stamp)
                                VALUES
                                (:staffID, :staffInfo)';
        $statementDeleteStaffSet = $db->prepare($queryDeleteStaffSet);
        $statementDeleteStaffSet->bindValue(':staffID', $staffID);
        $statementDeleteStaffSet->bindValue(':staffInfo', $staffInfo);
        $statementDeleteStaffSet->execute();
        $statementDeleteStaffSet->closeCursor();
        

        $queryGetLogin = 'SELECT *
        FROM staff_login
        WHERE staff_email=:email AND staff_ID=:staffID';
        $statementGetLogin = $db->prepare($queryGetLogin);
        $statementGetLogin->bindValue(':staffID', $staffID);
        $statementGetLogin->bindValue(':email', $email);
        $statementGetLogin->execute();
        $getStaffLogin = $statementGetLogin->fetch();
        $statementGetLogin->closeCursor();

        if(!isset($firstName) && !isset($lastName)){
        header('Location: http://192.168.2.157/volunteer/Staff.php');
        exit();
        }

    }
    elseif($gateKeyOne == FALSE || $gateKeyTwo == FALSE){
       //$_SESSION['error'] = 'User is already registered';
        //header('Location: http://192.168.2.157/volunteer/AddStaff.php');
        //exit();
    }
?>
<html>
	<head>
  		<title>Home</title>
		<meta http-equiv="refresh" content="3600">
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="addstaffdb_templete.css">
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
				<div class='WebGut'>
					<div class='CreateLoginSectBorder'>
                        <div class='CreateLoginSect'>
                            <div class='loginTitle'>
                                <a class='Title'>Log-in Information</a><br>
                            </div>
                            <div class='loginInformation'>
                                <div class='statementInformation'>
                                    <a class='statement'><br>Please keep log in details private as they deal with personal data.<br><br>Toggle the account to fully active it for the designated user.<br><br>
                                </div>
                                <a class="username">Email/Username: <?php echo $_SESSION['rememberemail'];?></a><br><br>
                                <a class="password">Password: <?php echo $_SESSION['passwordMemory'];?></a></a><br><br>
                                <form class='acceptForm' action="Staff.php" method="POST">
                                    <input class='agreeButton' type="submit" value="Understood" name='understandAction'/>
                                </form>
                            </div>
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