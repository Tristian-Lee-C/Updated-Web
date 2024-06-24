<?php
session_start();
require_once('database.php');

$TierSetName = filter_input(INPUT_POST,'TierName');
$getTierID = filter_input(INPUT_POST,'tierIDSend');

$queryCheck = 'SELECT *
               FROM tier_level_type
               WHERE tier_level = :TierName;';
$statementGetTier = $db->prepare($queryCheck);
$statementGetTier->bindValue(':TierName', $TierName);
$statementGetTier->execute();
$getTierMatch = $statementGetTier->fetch();
$statementGetTier->closeCursor();

if(empty($getTierMatch))
{
    $queryEdits = 'UPDATE tier_level_type SET
    tier_level=:TierSetName
    WHERE
    tierID=:getTierID;';
    $statementEditTier = $db->prepare($queryEdits);
    $statementEditTier->bindValue(':TierSetName', $TierSetName);
    $statementEditTier->bindValue(':getTierID', $getTierID);
    $statementEditTier->execute();
    $statementEditTier->closeCursor();


    header('Location: http://localhost/volunteer/Tiers.php');
    exit();
}

//header('Location: http://192.168.2.157/volunteer/Tiers.php');
//exit();
?>
