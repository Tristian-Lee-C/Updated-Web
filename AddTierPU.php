<?php
require_once('Tiers.php');
?>
    <head>
        <link rel="stylesheet" href="addtierpu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="addTierPopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Add a Service Tier</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="Tiers.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="addTierButtonPopUp" action="newtierdb.php" method="POST">
                    <label class='tierText'>Service Tier:
							<input type="text" name="tierName" required>
					</label>
                    <input type="submit" value="Add" name='addTier' class='addTierButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>