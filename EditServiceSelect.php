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

	$ServiceID = filter_input(INPUT_POST, 'serviceEdit_service_id');
	$volunteerID = filter_input(INPUT_POST,'serviceEdit_volunteer_id');
	$first_name = filter_input(INPUT_POST,'serviceEdit_first_name');
	$last_name = filter_input(INPUT_POST,'serviceEdit_last_name');
	$serviceEdit_school = filter_input(INPUT_POST,'serviceEdit_school');
	$serviceEdit_student_names = filter_input(INPUT_POST,'serviceEdit_student_names');
	$serviceEdit_minutes = filter_input(INPUT_POST,'serviceEdit_minutes');
	$serviceEdit_code = filter_input(INPUT_POST,'serviceEdit_code');
	$serviceEdit_tier = filter_input(INPUT_POST,'serviceEdit_tier');
	$serviceEdit_comment = filter_input(INPUT_POST,'serviceEdit_comment');
	$serviceEdit_date = filter_input(INPUT_POST,'serviceEdit_date');

	$queryEditSchool = 'SELECT school_name
				  FROM school_list
				  WHERE on_off = 1;';
	$statementSchool = $db->prepare($queryEditSchool);
	$statementSchool->execute();
	$serviceSchools = $statementSchool->fetchAll();
	$statementSchool->closeCursor();


	$queryEditService = 'SELECT service_code
				  FROM service_code
				  WHERE on_off = 1;';
	$statementServices = $db->prepare($queryEditService);
	$statementServices->execute();
	$serviceServices = $statementServices->fetchAll();
	$statementServices->closeCursor();

	
	$queryEditTier = 'SELECT tier_level
				  FROM tier_level_type';
	$statementTier = $db->prepare($queryEditTier);
	$statementTier->execute();
	$serviceTiers = $statementTier->fetchAll();
	$statementTier->closeCursor();

?>
<html>
	<head>
  		<title>Services</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="editserviceselect_template.css">
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
				<br><a class="editSelectServiceText">Edit Selected Service</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='volunteerInformation'><?php echo $first_name . " " . $last_name?>'s Service Entry</a>
					<a class='cancelButton' href= "Services.php">Back</a>
					<input form ='editServiceFormSect' class='editSelectServiceButton' type="submit" value="Change" name='editSelectService'>
					<br><br><hr></hr>
					<div class="formHolder">
					<form id ='editServiceFormSect' action="editservicedb.php" method="post" class='editselectserviceform'>
					<table class ='service_list'>
						<thead>
								<tr>
									<th class="odd"></th>
									<th>School</th>
									<th>Students' Name</th>
									<th>Service Time</th>
									<th>Service Code</th>
									<th>Service Type</th>
									<th>Comment</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<td><?php echo $first_name . " " . $last_name;?></td>
								<td><select class='schoolList' name="schoolChoice" required>
									<?php foreach ($serviceSchools as $serviceSchool) : ?>
											<option value='<?php echo $serviceSchool['school_name'];?>' <?php if($serviceEdit_school == $serviceSchool['school_name']){ ?> selected <?php }; ?>><?php echo $serviceSchool['school_name'];?></option>
										<?php endforeach; ?>
									</select></td>
								<td><textarea class='studentNames' name="studentNamesBox" cols="30" rows="2"><?php echo $serviceEdit_student_names;?></textarea></td>
								<td><input type='number' class='serviceNumber' name='serviceTime' value='<?php echo $serviceEdit_minutes;?>'></td>
								<td><select class='serviceCodes' name="serviceCodeChoice" required>
									<?php foreach ($serviceServices as $serviceService) : ?>
										<option value='<?php echo $serviceService['service_code'];?>' <?php if($serviceEdit_code == $serviceService['service_code']){ ?> selected <?php }; ?>><?php echo $serviceService['service_code'];?></option>
									<?php endforeach; ?>
								</select></td>
								<td><select class='serviceTiers' name="serviceTypeChoice" value='<?php echo $serviceEdit_tier;?>' required>
									<?php foreach ($serviceTiers as $serviceTier) : ?>
											<option value='<?php echo $serviceTier['tier_level'];?>' <?php if($serviceEdit_tier == $serviceTier['tier_level']){ ?> selected <?php }; ?>><?php echo $serviceTier['tier_level'];?></option>
										<?php endforeach; ?>
								</select></td>
								<td><textarea class='comment' name="serviceComment" cols="30" rows="2"><?php echo $serviceEdit_comment;?></textarea></td>
								<td><input type="date" class='date' name='serviceDate' value='<?php echo $serviceEdit_date;?>'></td>
							</tbody>
						</table>
						<input type='hidden' name='serviceID' value="<?php echo $ServiceID?>">
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