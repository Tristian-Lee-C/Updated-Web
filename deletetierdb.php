<?php
session_start();
require_once('database.php');

$tierID = filter_input(INPUT_POST,'tierIDSend');
$fact = TRUE;
$turnOffSchool = FALSE;
$dateExit = date("Y-m-d H:i:s");
$person = $_SESSION["user"];

$queryCheck = 'SELECT *
               FROM tier_level_type
               WHERE tierID = :tierID;';
$statementGetTier = $db->prepare($queryCheck);
$statementGetTier->bindValue(':tierID', $tierID);
$statementGetTier->execute();
$getTierMatch = $statementGetTier->fetch();
$statementGetTier->closeCursor();

$queryDelete = 'UPDATE deleted_tiers SET
delete_fact =:fact, delete_history =:dateExit, user_stamp =:person
WHERE
tierID = :tierID;';
$statementDeleteTierName = $db->prepare($queryDelete);
$statementDeleteTierName->bindValue(':fact', $fact);
$statementDeleteTierName->bindValue(':dateExit', $dateExit);
$statementDeleteTierName->bindValue(':person', $person);
$statementDeleteTierName->bindValue(':tierID', $tierID);
$statementDeleteTierName->execute();
$statementDeleteTierName->closeCursor();

$queryTurnOff = 'UPDATE tier_level_type SET
on_off =:turnOffSchool
WHERE
tierID = :tierID;';
$statementTurnOff = $db->prepare($queryTurnOff);
$statementTurnOff->bindValue(':turnOffSchool', $turnOffSchool);
$statementTurnOff->bindValue(':tierID', $tierID);
$statementTurnOff->execute();
$statementTurnOff->closeCursor();

header('Location: http://192.168.2.157/volunteer/Tiers.php');
exit();
?>