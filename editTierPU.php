<?php
require_once('Tiers.php');

$TierName = filter_input(INPUT_POST,'TierIDEdit');

$queryCheck = 'SELECT *
               FROM tier_level_type
               WHERE tierID = :TierName;';
$statementGetTier = $db->prepare($queryCheck);
$statementGetTier->bindValue(':TierName', $TierName);
$statementGetTier->execute();
$getTierMatch = $statementGetTier->fetch();
$statementGetTier->closeCursor();


?>
    <head>
        <link rel="stylesheet" href="edittierpu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="editTierPopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Edit a Service Tier</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="Tiers.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="editTierButtonPopUp" action="edittierdb.php" method="POST">
                    <label class='tierText'>Service Tier:
							<input type="text" name="TierName" value='<?php echo $getTierMatch['tier_level'];?>'required>
					</label>
                    <input type='hidden' name='tierIDSend' value='<?php echo $TierName;?>'>
                    <input type="submit" value="Edit" name='editTier' class='editTierButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>