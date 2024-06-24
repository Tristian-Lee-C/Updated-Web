<!DOCTYPE html>
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
		case 'Home':
			header('Location: http://192.168.2.157/volunteer/Home.php');
			break;
	}

	if(isset($_POST['logOutbutton'])){
		header('Location: http://192.168.2.157/volunteer/Login.php');
		session_destroy();
	}

	$setTime = date('Y');
	$query = 'SELECT volunteer_name.volunteerID, volunteer_name.volunteer_first_name, volunteer_name.volunteer_last_name, volunteer_type.volunteer_type, volunteer_year.volunteerYear
			  FROM volunteer_name 
			  INNER JOIN volunteer_type_history ON volunteer_type_history.volunteerID = volunteer_name.volunteerID
			  INNER JOIN volunteer_type ON volunteer_type.volunteer_typeID = volunteer_type_history.volunteer_typeID

			  INNER JOIN volunteer_year_queue ON volunteer_year_queue.volunteerID = volunteer_name.volunteerID
			  INNER JOIN volunteer_year ON volunteer_year.yearID = volunteer_year_queue.yearID

			  INNER JOIN exit_list ON exit_list.volunteerID = volunteer_name.volunteerID
			  WHERE volunteer_year.volunteerYear = :setTime AND exit_list.exit_fact = 0';

	$statement = $db->prepare($query);
	$statement->bindValue(':setTime', $setTime);
	$statement->execute();
	$services = $statement->fetchAll();
	$statement->closeCursor();

	


	$queryB = 'SELECT *
			  FROM school_queue 
			  INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID';
		$statementSchool = $db->prepare($queryB);
		$statementSchool->execute();
		$volunteersSchool = $statementSchool->fetchAll();
		$statementSchool->closeCursor();

?>

<html>
	<head>
  		<title>Services</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="services_template.css">
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
					<a class='serviceText'>Volunteer Service List</a><br><br>
					<hr></hr>
					<table class ='service_list'>
							<thead>
								<tr>
									<th>VID</th>
									<th>Volunteer Name</th>
									<th>Campus</th>
									<th>Type</th>
									<th>Number of Services</th>
									<th>Hours</th>
									<th>Last Service</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($services as $service) : 
									if(!empty($service['volunteerID'])) {?>
									
									<tr>
										<td><?php echo $service['volunteerID'];?></td>
										<td><?php echo $service['volunteer_first_name']; echo " ";?><?php echo $service['volunteer_last_name'];?></td>
										<td><?php 	$list = "";
													foreach($volunteersSchool as $VS)
													{
														if($VS['volunteerID'] == $service['volunteerID']){
															$wordPlaceCheck = substr($list, -2);
															if(!empty($list) && $wordPlaceCheck != ", ")
															{
																$list.=", ";
															};
															$list .=$VS['school_name'];
														};
													};
													echo $list;
													?></td>
										<td><?php echo $service['volunteer_type'];?></td>
										<?php 	$VID = $service['volunteerID'];
												$queryService = 'SELECT *, COUNT(service_entry.volunteerID) AS numberOfServices, SUM(service_entry.service_minutes) AS service_minutes
															FROM service_entry

															INNER JOIN deleted_services ON deleted_services.serviceID = service_entry.serviceID
															WHERE volunteerID = :VID AND delete_fact <> 1';
												$statementService = $db->prepare($queryService);
												$statementService -> bindValue(':VID', $VID);
												$statementService->execute();
												$volunteersServices = $statementService->fetchAll();
												$statementService->closeCursor();?>

										<?php foreach($volunteersServices as $volunteersService){										$specialIDs[]="";
											if(!in_array($volunteersService['volunteerID'], $specialIDs)){
												$specialIDs[] = $volunteersService['volunteerID'];?>
										<td><?php echo $volunteersService['numberOfServices'];?></td>
										<?php $calucation = $volunteersService['service_minutes']/60; ?>
										<td><?php echo $calucation;?></td>
										<td><?php 
										$VID = $service['volunteerID'];
										$queryDate ='SELECT service_date
													 FROM service_entry
													 WHERE volunteerID = :VID AND service_date <= NOW()
													 ORDER BY service_date DESC
													 LIMIT 1';

										$statementDate = $db->prepare($queryDate);
										$statementDate -> bindValue(':VID', $VID);
										$statementDate->execute();
										$Date = $statementDate->fetch();
										$statementDate->closeCursor();
										
										echo $Date['service_date'];?></td>
										<?php } else {?>
										<td><?php echo 0;?></td>
										<td><?php echo 0;?></td>
										<td><?php echo "No Services";?></td>
										<?php }}?>
										<td class='buttonactions'>

											<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || isset($_SESSION["is_user"])){?>
											<form class ="addServiceButton" action="AddService.php" method="POST">
											<input type='hidden' name='serviceAdd_volunteer_id' value="<?php echo $service['volunteerID'];?>">
											<input type='hidden' name='serviceAdd_first_name' value="<?php echo $service['volunteer_first_name'];?>">
											<input type='hidden' name='serviceAdd_last_name' value="<?php echo $service['volunteer_last_name'];?>">
											<input type="submit" value="Add" name='addService'></form>
											<?php }; ?>

											<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || !isset($_SESSION["is_user"])){?>
												<form class ="editServiceButton" action="EditService.php" method="POST"><input type="submit" value="Edit" name='editService'>
												<input type='hidden' name='serviceEdit_volunteer_id' value="<?php echo $service['volunteerID'];?>">
												<input type='hidden' name='serviceEdit_first_name' value="<?php echo $service['volunteer_first_name'];?>">
												<input type='hidden' name='serviceEdit_last_name' value="<?php echo $service['volunteer_last_name'];?>">	
											</form>
											<?php }; ?>

											<?php if (isset($_SESSION["is_administator"]) || !isset($_SESSION["is_moderator"]) && !isset($_SESSION["is_user"])){?>
											<form action='DeleteService.php' class ="deleteServiceButton" method='post'><input type="submit" value="Delete" name='deleteService'>
												<input type='hidden' name='serviceDelete_volunteer_id' value="<?php echo $service['volunteerID'];?>">
												<input type='hidden' name='serviceDelete_first_name' value="<?php echo $service['volunteer_first_name'];?>">
												<input type='hidden' name='serviceDelete_last_name' value="<?php echo $service['volunteer_last_name'];?>">		
											</form>
											<?php }; };?>

										</td>
									</tr>
									<?php endforeach; ?>
							</tbody>
					</table>
				</div>
			</main>
		</div>
	</body>
	<footer>
		<p>Copyright CISHOT &copy; <?php echo date('Y');?></p>
	</footer>
</html>