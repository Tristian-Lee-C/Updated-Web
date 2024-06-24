<?php
session_start();
require_once('database.php');

$tierName = filter_input(INPUT_POST,'tierName');

$queryCheck = 'SELECT *
               FROM tier_level_type
               WHERE tier_level = :tierName;';
$statementGetTier = $db->prepare($queryCheck);
$statementGetTier->bindValue(':tierName', $tierName);
$statementGetTier->execute();
$getTierMatch = $statementGetTier->fetch();
$statementGetTier->closeCursor();

if(empty($getTierMatch))
{
    $queryCreateTier = 'INSERT INTO tier_level_type
    (tier_level)
    VALUES
    (:tierName)';
    $statementCreateTier = $db->prepare($queryCreateTier);
    $statementCreateTier->bindValue(':tierName', $tierName);
    $statementCreateTier->execute();
    $statementCreateTier->closeCursor();

    $queryGetID = 'SELECT *
               FROM tier_level_type
               WHERE tier_level = :tierName;';
    $statementGetTierID = $db->prepare($queryGetID);
    $statementGetTierID->bindValue(':tierName', $tierName);
    $statementGetTierID->execute();
    $getSchoolID = $statementGetTierID->fetch();
    $statementGetTierID->closeCursor();

    $TierID = $getSchoolID['tierID'];

    $queryCreateSchool = 'INSERT INTO deleted_tiers
    (tierID)
    VALUES
    (:TierID)';
    $statementCreateSCode = $db->prepare($queryCreateSchool);
    $statementCreateSCode->bindValue(':TierID', $TierID);
    $statementCreateSCode->execute();
    $statementCreateSCode->closeCursor();




    header('Location: http://192.168.2.157/volunteer/Tiers.php');
    exit();
}

header('Location: http://192.168.2.157/volunteer/Tiers.php');
exit();
?>