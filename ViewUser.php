<!DOCTYPE html>
<?php

	$volunteerID = filter_input(INPUT_POST,'view_volunteer_id');
	$firstName = filter_input(INPUT_POST,'view_volunteer_firstName');
	$lastName = filter_input(INPUT_POST,'view_volunteer_lastName');
	$email = filter_input(INPUT_POST,'view_volunteer_email');
	$phone = filter_input(INPUT_POST,'view_volunteer_phone');
	$volunteerType = filter_input(INPUT_POST,'view_volunteer_type');
	$campus = filter_input(INPUT_POST,'view_volunteer_school');
	$birthday = filter_input(INPUT_POST,'view_volunteer_dob');
	//optional values//
	$street = filter_input(INPUT_POST,'view_volunteer_street');
	$city = filter_input(INPUT_POST,'view_volunteer_city');
	$stateAddress = filter_input(INPUT_POST,'view_volunteer_state');
	$zip = filter_input(INPUT_POST,'view_volunteer_zip');
	$county = filter_input(INPUT_POST,'view_volunteer_county');

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

	$queryVT = 'SELECT volunteer_type
	FROM volunteer_type;';
	$statementVT = $db->prepare($queryVT);
	$statementVT->execute();
	$volunteerTypesDB = $statementVT->fetchAll();
	$statementVT->closeCursor();

	$querySL = 'SELECT school_name
	FROM school_list;';
	$statementSL = $db->prepare($querySL);
	$statementSL->execute();
	$schools_listDB = $statementSL->fetchAll();
	$statementSL->closeCursor();

	$queryB = 'SELECT *
	FROM school_queue 
	INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID';
	$statementSchool = $db->prepare($queryB);
	$statementSchool->execute();
	$volunteersSchool = $statementSchool->fetchAll();
	$statementSchool->closeCursor();

	$queryServices = 'SELECT *
	FROM service_entry 
	INNER JOIN deleted_services ON deleted_services.serviceID = service_entry.serviceID
	WHERE volunteerID =:volunteerID AND delete_fact <> 1';
	$statementServices = $db->prepare($queryServices);
	$statementServices->bindValue(':volunteerID', $volunteerID);
	$statementServices->execute();
	$volunteersServicesMultis = $statementServices->fetchAll();
	$statementServices->closeCursor();

?>

<html>
	<head>
  		<title>Home</title>
		<meta http-equiv="refresh" content="3600">
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="viewuser_template.css">
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
					<a class='volunteerText'>View Profile</a><br><br>
					<hr></hr><br>
					<a class='volunteerInfo'><?php echo $firstName;?> <?php echo $lastName;?>'s Information</a><br><br>
					<div class='volunteerPersonal'>
					<div class='columnOne'>
						<label class='firstName'>First Name:
							<input type="text" name="firstName" value='<?php echo $firstName; ?>' disabled readonly><br></label>
							<br>
						<label class='lastName'>Last Name:
							<input type="text" name="lastName" value='<?php echo $lastName; ?>' disabled readonly><br></label>
							<br>
						<label class='emailAddress'>Email Address:
							<input type="text" name="email" value='<?php echo $email; ?>' disabled readonly><br></label>
							<br>
						<label class='phoneNumber'>Phone Number:
							<input type="text" name="phone" value='<?php echo $phone; ?>' disabled readonly><br></label>
							<br>
						<label class='volunteerType'>Volunteer Type:
							<select name='volunteer_types' value='<?php echo $volunteerType; ?>' readonly disabled>
								<?php foreach ($volunteerTypesDB as $volunteerTypeDB) : ?>
									<option value='<?php echo $volunteerTypeDB['volunteer_type'];?>' <?php if($volunteerType == $volunteerTypeDB['volunteer_type']){ ?> selected <?php }; ?>><?php echo $volunteerTypeDB['volunteer_type'];?></option>
								<?php endforeach; ?>
							</select>
							</label>
							<br><br>
							<label class='campus'><a class='campusText'>Campus:</a>
						<select name='school_names[]' size="5" readonly multiple disabled>
								<?php foreach ($schools_listDB as $school_listDB) : ?>
									<option value='<?php echo $school_listDB['school_name'];?>' <?php if(strpos($campus,$school_listDB['school_name']) !== false){ ?> selected <?php }; ?>><?php echo $school_listDB['school_name'];?></option>
								<?php endforeach; ?>
						</select>
							</label>
							<br><br>
						</div>
						<div class='columnTwo'>
						<label class='second'><a class='dateofBirth'>Date of Birth:</a>
							<input type="date" class='birthdaySet' name='birthday' value='<?php echo $birthday?>' disabled required>
						</label>
						<br><br>
						<label class='second'>Street Address:
							<input type="text" name="street" value='<?php echo $street?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>City:
							<input type="text" name="city" value='<?php echo $city?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>State:
							<input type="text" name="state" value='<?php echo $stateAddress?>' disabled readonly>
						</label>
							<br><br>
						<label class='second'>Zip:
							<input type="text" name="zip" value='<?php echo $zip?>' disabled readonly>
						</label>
						<br><br>
						<label class='second'>County:
							<input type="text" name="county" value='<?php echo $county?>' disabled readonly>
						</label>
						<br><br>
					</div>
							<input type='hidden' name='volunteerID' value="<?php echo $volunteerID;?>">
							<br><br>
					</div>
					<hr></hr><br>
					<a class='volunteerInfo'><?php echo $firstName;?> <?php echo $lastName;?>'s Records</a><br><br>
					<div class='RecordsSect'>
					<?php	$queryService = 'SELECT *, COUNT(service_entry.volunteerID) AS numberOfServices, SUM(service_entry.service_minutes) AS service_minutes
											FROM service_entry

											INNER JOIN deleted_services ON deleted_services.serviceID = service_entry.serviceID
											WHERE volunteerID = :volunteerID AND delete_fact <> 1';
								$statementService = $db->prepare($queryService);
								$statementService -> bindValue(':volunteerID', $volunteerID);
								$statementService->execute();
								$volunteersServices = $statementService->fetchAll();
								$statementService->closeCursor();?>
						<?php foreach($volunteersServices as $volunteersService){										
							$specialIDs[]="";
							if(!in_array($volunteersService['volunteerID'], $specialIDs)){
								$specialIDs[] = $volunteersService['volunteerID'];?>
					<a class='visitText'>Volunteer Visits:&nbsp;
						<?php echo $volunteersService['numberOfServices'];?></a>
						<?php $calucation = $volunteersService['service_minutes']/60; ?>
					<a class='hourText'>Total Volunteer Hours:&nbsp;
						<?php echo $calucation;?></a>
						<?php } else { ?>
							<a class='visitText'>Volunteer Visits: 0</a>
							<a class='hourText'>Total Volunteer Hours: 0</a>
						<?php }}?><br><br>
							</div>
						<div class='borderStyleRecords'>
							<div class='Scroll'>
						<table class ='service_list'>
							<thead>
								<tr>
									<th>School</th>
									<th>Service Time</th>
									<th>Date</th>
								</tr>
							</thead>
							<?php foreach ($volunteersServicesMultis as $volunteersServiceMulti): ?>
							<tbody>
								<?php 
									$school = $volunteersServiceMulti['schoolID'];
									$querySchool = 'SELECT school_name
													FROM school_list
													WHERE schoolID =:school';
									$statementschoolID = $db->prepare($querySchool);
									$statementschoolID->bindValue(':school', $school);
									$statementschoolID->execute();
									$schoolGet = $statementschoolID->fetch();
									$statementschoolID->closeCursor();
								?>
								<td><?php echo $schoolGet['school_name'];?></td>
								<td><?php echo $volunteersServiceMulti['service_minutes'];?> Minutes</td>
								<td>Visited on <?php echo $volunteersServiceMulti['service_date'];?></td>
							</tbody>
							<?php endforeach;?>
						</table>
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

