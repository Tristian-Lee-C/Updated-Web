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

	$ServiceID = filter_input(INPUT_POST, 'serviceDelete_service_id');
	$volunteerID = filter_input(INPUT_POST,'serviceDelete_volunteer_id');
	$first_name = filter_input(INPUT_POST,'serviceDelete_first_name');
	$last_name = filter_input(INPUT_POST,'serviceDelete_last_name');
	$serviceDelete_school = filter_input(INPUT_POST,'serviceDelete_school');
	$serviceDelete_student_names = filter_input(INPUT_POST,'serviceDelete_student_names');
	$serviceDelete_minutes = filter_input(INPUT_POST,'serviceDelete_minutes');
	$serviceDelete_code = filter_input(INPUT_POST,'serviceDelete_code');
	$serviceDelete_tier = filter_input(INPUT_POST,'serviceDelete_tier');
	$serviceDelete_comment = filter_input(INPUT_POST,'serviceDelete_comment');
	$serviceDelete_date = filter_input(INPUT_POST,'serviceDelete_date');

	$queryDeleteSchool = 'SELECT school_name
				  FROM school_list';
	$statementSchool = $db->prepare($queryDeleteSchool);
	$statementSchool->execute();
	$serviceSchools = $statementSchool->fetchAll();
	$statementSchool->closeCursor();


	$queryDeleteService = 'SELECT service_code
				  FROM service_code';
	$statementServices = $db->prepare($queryDeleteService);
	$statementServices->execute();
	$serviceServices = $statementServices->fetchAll();
	$statementServices->closeCursor();

	
	$queryDeleteTier = 'SELECT tier_level
				  FROM tier_level_type';
	$statementTier = $db->prepare($queryDeleteTier);
	$statementTier->execute();
	$serviceTiers = $statementTier->fetchAll();
	$statementTier->closeCursor();

	$queryDeleteReason = 'SELECT delete_reason
						FROM delete_reason_table';
	$statementDeleteReason = $db->prepare($queryDeleteReason);
	$statementDeleteReason->execute();
	$Delete_reasons = $statementDeleteReason->fetchAll();
	$statementDeleteReason->closeCursor();

?>
<html>
	<head>
  		<title>Services</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="deleteserviceselect_template.css">
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
				<br><a class="deleteSelectServiceText">Delete Selected Service</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='volunteerInformation'><?php echo $first_name . " " . $last_name?>'s Service Entry</a>
					<a class='cancelButton' href= "Services.php">Back</a>
					<input form ='deleteServiceFormSect' class='deleteSelectServiceButton' type="submit" value="Delete" name='deleteSelectService'>
					<br><br><hr></hr>
					<div class="formHolder">
					<form id ='deleteServiceFormSect' action="deleteservicedb.php" method="post" class='deleteselectserviceform'>
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
								<td><select class='schoolList' name="schoolChoice" readonly disabled>
									<?php foreach ($serviceSchools as $serviceSchool) : ?>
											<option value='<?php echo $serviceSchool['school_name'];?>' <?php if($serviceDelete_school == $serviceSchool['school_name']){ ?> selected <?php }; ?>readonly disabled><?php echo $serviceSchool['school_name'];?></option>
										<?php endforeach; ?>
									</select></td>
								<td><textarea class='studentNames' name="studentNamesBox" cols="30" rows="2" readonly disabled><?php echo $serviceDelete_student_names;?></textarea></td>
								<td><input type='number' class='serviceNumber' name='serviceTime' value='<?php echo $serviceDelete_minutes;?>' readonly disabled></td>
								<td><select class='serviceCodes' name="serviceCodeChoice" readonly disabled>
									<?php foreach ($serviceServices as $serviceService) : ?>
										<option value='<?php echo $serviceService['service_code'];?>' <?php if($serviceDelete_code == $serviceService['service_code']){ ?> selected <?php }; ?>readonly disabled><?php echo $serviceService['service_code'];?></option>
									<?php endforeach; ?>
								</select></td>
								<td><select class='serviceTiers' name="serviceTypeChoice" value='<?php echo $serviceDelete_tier;?>' readonly disabled>
									<?php foreach ($serviceTiers as $serviceTier) : ?>
											<option value='<?php echo $serviceTier['tier_level'];?>' <?php if($serviceDelete_tier == $serviceTier['tier_level']){ ?> selected <?php }; ?>readonly disabled><?php echo $serviceTier['tier_level'];?></option>
										<?php endforeach; ?>
								</select></td>
								<td><textarea class='comment' name="serviceComment" cols="30" rows="2" readonly disabled><?php echo $serviceDelete_comment;?></textarea></td>
								<td><input type="date" class='date' name='serviceDate' value='<?php echo $serviceDelete_date;?>' readonly disabled></td>
							</tbody>
						</table>
						<br><br><br>
						<br><br>

							<br><a class="deleteServiceTextZone">Delete Details</a>

							<hr></hr>
							<br><br><br>
							<label class='exitReason'>Deletion Reason:
							<select name="exit_dropdown"><br>
							<?php foreach ($Delete_reasons as $Delete_reason) : ?>
									<option value='<?php echo $Delete_reason['delete_reason'];?>'><?php echo $Delete_reason['delete_reason'];?></option>
								<?php endforeach; ?>
								</select>
								</label>
							<br>

							<label class='exitComment'><a class='exitText'>Comment:</a><br>
							<textarea class='paragraphZone' name="exitParagraphComment" cols="60" rows="10"></textarea></label>

							<input type='hidden' name='volunteerID' value="<?php echo $volunteerID;?>">
							<input type='hidden' name='serviceID' value="<?php echo $ServiceID;?>">
							<br><br>
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