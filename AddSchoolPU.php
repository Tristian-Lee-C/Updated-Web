<?php
require_once('Schools.php');
?>
    <head>
        <link rel="stylesheet" href="addschoolpu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="addSchoolPopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Add a school</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="Schools.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="addSchoolButtonPopUp" action="newschooldb.php" method="POST">
                    <label class='schoolText'>School Name:
							<input type="text" name="schoolName" required>
					</label>
                    <input type="submit" value="Add" name='addSchools' class='addSchoolButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>