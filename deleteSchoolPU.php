<?php
require_once('Schools.php');

$schoolName = filter_input(INPUT_POST,'schoolIDDelete');

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
        <link rel="stylesheet" href="deleteschoolpu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="deleteSchoolPopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Delete a school</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="Schools.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="deleteSchoolButtonPopUp" action="deleteschooldb.php" method="POST">
                    <label class='schoolText'>Confirm Deletion of <?php echo $getSchoolMatch['school_name']; ?>? </label>
                    <input type='hidden' name='schoolIDSend' value='<?php echo $schoolName;?>'>
                    <input type="submit" value="YES" name='deleteSchools' class='deleteSchoolButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>