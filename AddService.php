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

	$volunteerID = filter_input(INPUT_POST,'serviceAdd_volunteer_id');
	$first_name = filter_input(INPUT_POST,'serviceAdd_first_name');
	$last_name = filter_input(INPUT_POST,'serviceAdd_last_name');

	$querySC="SELECT *
			FROM service_code
			WHERE on_off = 1;";
	$statementSC = $db->prepare($querySC);
	$statementSC->execute();
	$service_codes = $statementSC->fetchAll();
	$statementSC->closeCursor();

	$querySL="SELECT *
				FROM school_list
				WHERE on_off = 1;";
	$statementSL = $db->prepare($querySL);
	$statementSL->execute();
	$schools = $statementSL->fetchAll();
	$statementSL->closeCursor();

	$queryTL="SELECT *
				FROM tier_level_type";
	$statementTL = $db->prepare($queryTL);
	$statementTL->execute();
	$tierLevels = $statementTL->fetchAll();
	$statementTL->closeCursor();

	$staff = $_SESSION["user"];

?>
<html>
	<head>
  		<title>Services</title>
  		<link rel="icon" type="image/x-icon" href="images/favicon.ico">
		<link rel="stylesheet" href="css_reset.css">
		<link rel="stylesheet" href="header_template.css">
		<link rel="stylesheet" href="addservice_template.css">
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
				<br><a class="addServiceText">Add Service</a><br><br>
				<hr></hr>
					<div class="dashboardText">
					<a class='textSpace'></a>
					<a class='volunteerInformation'>Volunteer's Information</a>
					<a class='cancelButton' href= "Services.php">Back</a>
					<input form = 'addServiceFormSect' class='addServiceButton' type="submit" value="Add" name='addService'>
					<br><br><hr></hr>
					<div class="formHolder">
					<form id='addServiceFormSect' action="addservicedb.php" method="post" class='addserviceform'>
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
								<td><?php echo $first_name . " " . $last_name?></td>
								<td><select class='schoolList' name="schoolChoice" required>
									<?php foreach ($schools as $school) : ?>
											<option value='<?php echo $school['school_name'];?>'><?php echo $school['school_name'];?></option>
										<?php endforeach; ?>
									</select></td>
								<td><textarea class='studentNames' name="studentNamesBox" cols="30" rows="2"></textarea></td>
								<td><input type='number' class='serviceNumber' name='serviceTime' value="" required></td>
								<td><select class='serviceCodes' name="serviceCodeChoice" required>
									<?php foreach ($service_codes as $service_code) : ?>
										<option value='<?php echo $service_code['service_code'];?>'><?php echo $service_code['service_code'];?></option>
									<?php endforeach; ?>
								</select></td>
								<td><select class='serviceTiers' name="serviceTypeChoice" required>
									<?php foreach ($tierLevels as $tierLevel) : ?>
											<option value='<?php echo $tierLevel['tier_level'];?>'><?php echo $tierLevel['tier_level'];?></option>
										<?php endforeach; ?>
								</select></td>
								<td><textarea class='comment' name="serviceComment" cols="30" rows="2"></textarea></td>
								<td><input type="date" class='date' name='serviceDate'></td>
							</tbody>
						</table>
						<input type='hidden' name='volunteer' value="<?php echo $volunteerID;?>">
						<input type='hidden' name='staffEntry' value="<?php echo $staff;?>">
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