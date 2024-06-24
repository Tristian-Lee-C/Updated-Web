<?php
require_once('Schools.php');

$schoolName = filter_input(INPUT_POST,'schoolIDEdit');

$queryCheck = 'SELECT *
               FROM school_list
               WHERE schoolID = :schoolName;';
$statementGetSchool = $db->prepare($queryCheck);
$statementGetSchool->bindValue(':schoolName', $schoolName);
$statementGetSchool->execute();
$getSchoolMatch = $statementGetSchool->fetch();
$statementGetSchool->closeCursor();


?>
    <head>
        <link rel="stylesheet" href="editschoolpu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="editSchoolPopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Edit a school</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="Schools.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="editSchoolButtonPopUp" action="editschooldb.php" method="POST">
                    <label class='schoolText'>School Name:
							<input type="text" name="schoolName" value='<?php echo $getSchoolMatch['school_name'];?>'required>
					</label>
                    <input type='hidden' name='schoolIDSend' value='<?php echo $schoolName;?>'>
                    <input type="submit" value="Edit" name='editSchools' class='editSchoolButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>