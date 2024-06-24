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

	$volunteerID = filter_input(INPUT_POST,'serviceEdit_volunteer_id');
	$first_name = filter_input(INPUT_POST,'serviceEdit_first_name');
	$last_name = filter_input(INPUT_POST,'serviceEdit_last_name');

	$queryServices = 'SELECT *
	FROM service_entry 
	INNER JOIN deleted_services ON deleted_services.serviceID = service_entry.serviceID
	WHERE volunteerID =:volunteerID AND delete_fact <> 1';
	$statementServices = $db->prepare($queryServices);
	$statementServices->bindValue(':volunteerID', $volunteerID);
	$statementServices->execute();
	$volunteersServices = $statementServices->fetchAll();
	$statementServices->closeCursor();


?>
<html>
	<head>
  		<title>Services</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="editservice_template.css">
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
				<br><a class="editServiceText">Edit Service</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='volunteerInformation'><?php echo $first_name . " " . $last_name?>'s Service History</a>
					<a class='cancelButton' href= "Services.php">Back</a>
					<br><br><hr></hr>
					<div class="formHolder">
					<form action="EditServiceSelect.php" method="post" class='editserviceform'>
					<table class ='service_list'>
						<thead>
								<tr>
									<th>School</th>
									<th>Students' Name</th>
									<th>Service Time</th>
									<th>Service Code</th>
									<th>Service Type</th>
									<th>Comment</th>
									<th>Date</th>
									<th>Edit</th>
								</tr>
							</thead>
							<?php foreach ($volunteersServices as $volunteersService): ?>
							<tbody>
								<?php 
									$school = $volunteersService['schoolID'];
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
								<td><?php echo $volunteersService['student_names'];?></td>
								<td><?php echo $volunteersService['service_minutes'];?></td>
								<?php 
									$code = $volunteersService['service_codeID'];
									$queryCode = 'SELECT service_code
													FROM service_code
													WHERE service_codeID =:code';
									$statementCodeID = $db->prepare($queryCode);
									$statementCodeID->bindValue(':code', $code);
									$statementCodeID->execute();
									$CodeGet = $statementCodeID->fetch();
									$statementCodeID->closeCursor();
								?>
								<td><?php echo $CodeGet['service_code'];?></td>
								<?php 
									$tier = $volunteersService['tierID'];
									$queryTier = 'SELECT tier_level
													FROM tier_level_type
													WHERE tierID =:tier';
									$statementTierID = $db->prepare($queryTier);
									$statementTierID->bindValue(':tier', $tier);
									$statementTierID->execute();
									$TierGet = $statementTierID->fetch();
									$statementTierID->closeCursor();
									
								?>
								<td><?php echo $TierGet['tier_level'];?></td>
								<td><?php
									if (empty($volunteersService['service_comment']))
											echo "N/A";
									else
										echo $volunteersService['service_comment'];?></td>
								<td><?php echo $volunteersService['service_date'];?></td>
								<td>
								<form action='EditServiceSelect.php' class ="editServiceEditButton" method='post'>
									<input type='hidden' name='serviceEdit_service_id' value="<?php echo $volunteersService['serviceID'];?>">
									<input type='hidden' name='serviceEdit_volunteer_id' value="<?php echo $volunteerID;?>">
									<input type='hidden' name='serviceEdit_first_name' value="<?php echo $first_name;?>">
									<input type='hidden' name='serviceEdit_last_name' value="<?php echo $last_name;?>">	
									<input type='hidden' name='serviceEdit_school' value="<?php echo $schoolGet['school_name'];?>">	
									<input type='hidden' name='serviceEdit_student_names' value="<?php echo $volunteersService['student_names'];?>">	
									<input type='hidden' name='serviceEdit_minutes' value="<?php echo $volunteersService['service_minutes'];?>">	
									<input type='hidden' name='serviceEdit_code' value="<?php echo $CodeGet['service_code'];?>">	
									<input type='hidden' name='serviceEdit_tier' value="<?php echo $TierGet['tier_level'];?>">	
									<input type='hidden' name='serviceEdit_comment' value="<?php echo $volunteersService['service_comment'];?>">	
									<input type='hidden' name='serviceEdit_date' value="<?php echo $volunteersService['service_date'];?>">	
									<input type="submit" value="Edit" name='editService'>
								</form>
								</td>
							</tbody>
							<?php endforeach;?>
						</table>
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