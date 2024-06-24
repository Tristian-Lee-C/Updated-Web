<?php
session_start();
require_once('database.php');

$scodeID = filter_input(INPUT_POST,'scodeIDSend');
$fact = TRUE;
$turnOffSchool = FALSE;
$dateExit = date("Y-m-d H:i:s");
$person = $_SESSION["user"];

$queryCheck = 'SELECT *
               FROM service_code
               WHERE service_codeID = :scodeID;';
$statementGetSCode = $db->prepare($queryCheck);
$statementGetSCode->bindValue(':scodeID', $scodeID);
$statementGetSCode->execute();
$getSCodeMatch = $statementGetSCode->fetch();
$statementGetSCode->closeCursor();

$queryDelete = 'UPDATE deleted_servicecode SET
delete_fact =:fact, delete_history =:dateExit, user_stamp =:person
WHERE
service_codeID = :scodeID;';
$statementDeleteSchoolName = $db->prepare($queryDelete);
$statementDeleteSchoolName->bindValue(':fact', $fact);
$statementDeleteSchoolName->bindValue(':dateExit', $dateExit);
$statementDeleteSchoolName->bindValue(':person', $person);
$statementDeleteSchoolName->bindValue(':scodeID', $scodeID);
$statementDeleteSchoolName->execute();
$statementDeleteSchoolName->closeCursor();

$queryTurnOff = 'UPDATE service_code SET
on_off =:turnOffSchool
WHERE
service_codeID = :scodeID;';
$statementTurnOff = $db->prepare($queryTurnOff);
$statementTurnOff->bindValue(':turnOffSchool', $turnOffSchool);
$statementTurnOff->bindValue(':scodeID', $scodeID);
$statementTurnOff->execute();
$statementTurnOff->closeCursor();

header('Location: http://192.168.2.157/volunteer/serviceTool.php');
exit();
?>