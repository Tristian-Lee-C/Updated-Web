<?php
require_once('Tiers.php');

$tierName = filter_input(INPUT_POST,'TierIDDelete');

$queryCheck = 'SELECT *
               FROM tier_level_type
               WHERE tierID = :tierName;';
$statementTier = $db->prepare($queryCheck);
$statementTier->bindValue(':tierName', $tierName);
$statementTier->execute();
$getTierMatch = $statementTier->fetch();
$statementTier->closeCursor();


?>
    <head>
        <link rel="stylesheet" href="deletetierpu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="deleteTierPopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Delete a Service Tier</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="Tiers.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="deleteTierButtonPopUp" action="deletetierdb.php" method="POST">
                    <label class='tierText'>Confirm Deletion of <?php echo $getTierMatch['tier_level']; ?>? </label>
                    <input type='hidden' name='tierIDSend' value='<?php echo $tierName;?>'>
                    <input type='submit' value='YES' name='deleteTier' class='deleteTierButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>