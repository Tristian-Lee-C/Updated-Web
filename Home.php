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
	}

	if(isset($_POST['logOutbutton'])){
		header('Location: http://192.168.2.157/volunteer/Login.php');
		session_destroy();
	}

	if(isset($_POST['logOutbutton'])){
		header('Location: http://192.168.2.157/volunteer/Login.php');
		session_destroy();
	}

	if(isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){
		$setTime = date('Y');
		$query = 'SELECT volunteer_name.volunteerID, volunteer_first_name, volunteer_last_name, volunteer_phone, volunteer_email, volunteer_type.volunteer_type, school_list.school_name, school_status_mode.statusID, volunteer_year.volunteerYear, birth_date, street, state_address, zip, county, city
				FROM volunteer_name 
				INNER JOIN volunteer_type_history ON volunteer_type_history.volunteerID = volunteer_name.volunteerID
				INNER JOIN volunteer_type ON volunteer_type.volunteer_typeID = volunteer_type_history.volunteer_typeID
				INNER JOIN school_queue ON school_queue.volunteerID = volunteer_name.volunteerID
				INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID
				INNER JOIN school_status_queue ON school_status_queue.schoolID = school_list.schoolID
				INNER JOIN school_status_mode ON school_status_mode.modeID = school_status_queue.modeID
				INNER JOIN volunteer_year_queue ON volunteer_year_queue.volunteerID = volunteer_name.volunteerID
				INNER JOIN volunteer_year ON volunteer_year.yearID = volunteer_year_queue.yearID
				INNER JOIN exit_list ON exit_list.volunteerID = volunteer_name.volunteerID
				WHERE volunteer_year.volunteerYear = :setTime AND exit_list.exit_fact = 0';

		$statement = $db->prepare($query);
		$statement->bindValue(':setTime', $setTime);
		$statement->execute();
		$volunteers = $statement->fetchAll();
		$statement->closeCursor();
	}
	elseif(isset($_SESSION["is_user"]) && $_SESSION["user_level"] == "Partner"){
		$userCheck = $_SESSION["user"];
		$query = 'SELECT *
				  FROM volunteer_login
				  WHERE volunteer_email=:userCheck';
		$statement = $db->prepare($query);
		$statement->bindValue(':userCheck', $userCheck);
		$statement->execute();
		$volunteersID = $statement->fetch();
		$volunteerIDCatch = $volunteersID['volunteerID'];
		$statement->closeCursor();

		$baylorSetting = "Baylor Buddies";
		$setTime = date('Y');
		$query = 'SELECT volunteer_name.volunteerID, volunteer_first_name, volunteer_last_name, volunteer_phone, volunteer_email, volunteer_type.volunteer_type, school_list.school_name, school_status_mode.statusID, volunteer_year.volunteerYear, birth_date, street, state_address, zip, county, city
				  FROM volunteer_name 
				  INNER JOIN volunteer_type_history ON volunteer_type_history.volunteerID = volunteer_name.volunteerID
				  INNER JOIN volunteer_type ON volunteer_type.volunteer_typeID = volunteer_type_history.volunteer_typeID
				  INNER JOIN school_queue ON school_queue.volunteerID = volunteer_name.volunteerID
				  INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID
				  INNER JOIN school_status_queue ON school_status_queue.schoolID = school_list.schoolID
				  INNER JOIN school_status_mode ON school_status_mode.modeID = school_status_queue.modeID
				  INNER JOIN volunteer_year_queue ON volunteer_year_queue.volunteerID = volunteer_name.volunteerID
				  INNER JOIN volunteer_year ON volunteer_year.yearID = volunteer_year_queue.yearID
				  INNER JOIN exit_list ON exit_list.volunteerID = volunteer_name.volunteerID
				  WHERE volunteer_type.volunteer_type=:baylorSetting';
		$statement = $db->prepare($query);
		$statement->bindValue(':baylorSetting', $baylorSetting);
		$statement->execute();
		$volunteers = $statement->fetchAll();
		$statement->closeCursor();

	}
	else{
		$userCheck = $_SESSION["user"];
		$query = 'SELECT *
				  FROM volunteer_login
				  WHERE volunteer_email=:userCheck';
		$statement = $db->prepare($query);
		$statement->bindValue(':userCheck', $userCheck);
		$statement->execute();
		$volunteersID = $statement->fetch();
		$volunteerIDCatch = $volunteersID['volunteerID'];
		$statement->closeCursor();

		$setTime = date('Y');
		$query = 'SELECT volunteer_name.volunteerID, volunteer_first_name, volunteer_last_name, volunteer_phone, volunteer_email, volunteer_type.volunteer_type, school_list.school_name, school_status_mode.statusID, volunteer_year.volunteerYear, birth_date, street, state_address, zip, county, city
				  FROM volunteer_name 
				  INNER JOIN volunteer_type_history ON volunteer_type_history.volunteerID = volunteer_name.volunteerID
				  INNER JOIN volunteer_type ON volunteer_type.volunteer_typeID = volunteer_type_history.volunteer_typeID
				  INNER JOIN school_queue ON school_queue.volunteerID = volunteer_name.volunteerID
				  INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID
				  INNER JOIN school_status_queue ON school_status_queue.schoolID = school_list.schoolID
				  INNER JOIN school_status_mode ON school_status_mode.modeID = school_status_queue.modeID
				  INNER JOIN volunteer_year_queue ON volunteer_year_queue.volunteerID = volunteer_name.volunteerID
				  INNER JOIN volunteer_year ON volunteer_year.yearID = volunteer_year_queue.yearID
				  INNER JOIN exit_list ON exit_list.volunteerID = volunteer_name.volunteerID
				  WHERE volunteer_name.volunteerID =:volunteerIDCatch';
		$statement = $db->prepare($query);
		$statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
		$statement->execute();
		$volunteers = $statement->fetchAll();
		$statement->closeCursor();
	};

	$query = 'SELECT *
			  FROM school_queue 
			  INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID';
		$statementSchool = $db->prepare($query);
		$statementSchool->execute();
		$volunteersSchool = $statementSchool->fetchAll();
		$statementSchool->closeCursor();


?>

<html>
	<head>
  		<title>Home</title>
		<meta http-equiv="refresh" content="3600">
		<link rel="stylesheet" href="css_reset.css">
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="home_template.css">
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
					<a class='volunteerText'>Volunteer List</a><br><br>
					<hr></hr>
					<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || !isset($_SESSION["is_user"])){?>
					<form class ="addVolunteerButton" action="AddUser.php" method="POST"><input type="submit" value="Add" name='addVolunteer'></form>
					<?php }; ?>
					<table class ='volunteer_list'>
							<thead>
								<tr>
									<th>VID</th>
									<th>Volunteer Name</th>
									<th>Phone Number</th>
									<th>Email</th>
									<th>Type</th>
									<th>Campus</th>
									<th>Campus Type</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($volunteers as $volunteer) :
										$specialIDs[]="";
										if(!in_array($volunteer['volunteerID'], $specialIDs)){
											$specialIDs[] = $volunteer['volunteerID'];?>
									<tr>
										<td><?php echo $volunteer['volunteerID'];?></td>
										<td><?php echo $volunteer['volunteer_first_name'];?> <?php echo $volunteer['volunteer_last_name'];?></td>
										<?php $phoneOne = substr($volunteer['volunteer_phone'], 0, 3); $phoneTwo = substr($volunteer['volunteer_phone'], 3, 3); $phoneThree = substr($volunteer['volunteer_phone'], 6); $phoneformat =  $phoneOne . '-' . $phoneTwo . '-' . $phoneThree;?>
										<td><?php echo $phoneformat?></td>
										<td><?php echo $volunteer['volunteer_email'];?></td>
										<td><?php echo $volunteer['volunteer_type'];?></td>
										<td><?php 	$list = "";
													foreach($volunteersSchool as $VS)
													{
														if($VS['volunteerID'] == $volunteer['volunteerID']){
															$wordPlaceCheck = substr($list, -2);
															if(!empty($list) && $wordPlaceCheck != ", ")
															{
																$list.=", ";
															};
															$list .=$VS['school_name'];
														};
													};
													echo $list;
													?>
											</td>
										<td><?php echo $volunteer['statusID'];?></td> 
										<td class='buttonactions'>

											<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || isset($_SESSION["is_user"])){?>
											<form class ="viewVolunteerButton" action="ViewUser.php" method="POST">
											<input type='hidden' name='view_volunteer_id' value='<?php echo $volunteer['volunteerID'];?>'>
											<input type='hidden' name='view_volunteer_id' value='<?php echo $volunteer['volunteerID'];?>'>
											<input type='hidden' name='view_volunteer_firstName' value='<?php echo $volunteer['volunteer_first_name'];?>'>
											<input type='hidden' name='view_volunteer_lastName' value='<?php echo $volunteer['volunteer_last_name'];?>'>
											<input type='hidden' name='view_volunteer_phone' value='<?php echo $volunteer['volunteer_phone'];?>'>
											<input type='hidden' name='view_volunteer_email' value='<?php echo $volunteer['volunteer_email'];?>'>
											<input type='hidden' name='view_volunteer_type' value='<?php echo $volunteer['volunteer_type'];?>'>
											<input type='hidden' name='view_volunteer_school' value='<?php echo $list;?>'>
											<input type='hidden' name='view_volunteer_dob' value='<?php echo $volunteer['birth_date'];?>'>
											<input type='hidden' name='view_volunteer_street' value="<?php echo $volunteer['street'];?>">
											<input type='hidden' name='view_volunteer_city' value='<?php echo $volunteer['city'];?>'>
											<input type='hidden' name='view_volunteer_state' value='<?php echo $volunteer['state_address'];?>'>
											<input type='hidden' name='view_volunteer_zip' value='<?php echo $volunteer['zip'];?>'>
											<input type='hidden' name='view_volunteer_county' value='<?php echo $volunteer['county'];?>'>
											<input type='submit' value='View' name='viewVolunteer'>
											</form>
											<?php }; ?>

											<?php if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"]) || !isset($_SESSION["is_user"])){?>
												<form class ="editVolunteerButton" action="EditUser.php" method="POST">
													<input type='hidden' name='edit_volunteer_id' value='<?php echo $volunteer['volunteerID'];?>'>
													<input type='hidden' name='edit_volunteer_firstName' value='<?php echo $volunteer['volunteer_first_name'];?>'>
													<input type='hidden' name='edit_volunteer_lastName' value='<?php echo $volunteer['volunteer_last_name'];?>'>
													<input type='hidden' name='edit_volunteer_phone' value='<?php echo $volunteer['volunteer_phone'];?>'>
													<input type='hidden' name='edit_volunteer_email' value='<?php echo $volunteer['volunteer_email'];?>'>
													<input type='hidden' name='edit_volunteer_type' value='<?php echo $volunteer['volunteer_type'];?>'>
													<input type='hidden' name='edit_volunteer_school' value='<?php echo $list;?>'>
													<input type='hidden' name='edit_volunteer_dob' value='<?php echo $volunteer['birth_date'];?>'>
													<input type='hidden' name='edit_volunteer_street' value='<?php echo $volunteer['street'];?>'>
													<input type='hidden' name='edit_volunteer_city' value='<?php echo $volunteer['city'];?>'>
													<input type='hidden' name='edit_volunteer_state' value='<?php echo $volunteer['state_address'];?>'>
													<input type='hidden' name='edit_volunteer_zip' value='<?php echo $volunteer['zip'];?>'>
													<input type='hidden' name='edit_volunteer_county' value='<?php echo $volunteer['county'];?>'>
													<input type='submit' value='Edit' name='editVolunteer'>
												</form>
											<?php }; ?>

											<?php if (isset($_SESSION["is_administator"]) || !isset($_SESSION["is_moderator"]) && !isset($_SESSION["is_user"])){?>
											<form action='DeleteUser.php' class ="deleteVolunteerButton" method='post'>
													<input type='hidden' name='delete_volunteer_id' value='<?php echo $volunteer['volunteerID'];?>'>
													<input type='hidden' name='delete_volunteer_firstName' value='<?php echo $volunteer['volunteer_first_name'];?>'>
													<input type='hidden' name='delete_volunteer_lastName' value='<?php echo $volunteer['volunteer_last_name'];?>'>
													<input type='hidden' name='delete_volunteer_phone' value='<?php echo $volunteer['volunteer_phone'];?>'>
													<input type='hidden' name='delete_volunteer_email' value='<?php echo $volunteer['volunteer_email'];?>'>
													<input type='hidden' name='delete_volunteer_type' value='<?php echo $volunteer['volunteer_type'];?>'>
													<input type='hidden' name='delete_volunteer_school' value='<?php echo $list;?>'>
													<input type='hidden' name='delete_volunteer_dob' value='<?php echo $volunteer['birth_date'];?>'>
													<input type='hidden' name='delete_volunteer_street' value='<?php echo $volunteer['street'];?>'>
													<input type='hidden' name='delete_volunteer_city' value='<?php echo $volunteer['city'];?>'>
													<input type='hidden' name='delete_volunteer_state' value='<?php echo $volunteer['state_address'];?>'>
													<input type='hidden' name='delete_volunteer_zip' value='<?php echo $volunteer['zip'];?>'>
													<input type='hidden' name='delete_volunteer_county' value='<?php echo $volunteer['county'];?>'>
													<input type='submit' value='Delete' name='deleteVolunteer'>
											</form>
											<?php }; ?>

										</td>
									</tr>
								<?php };endforeach; ?>
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