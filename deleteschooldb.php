<?php
session_start();
require_once('database.php');

$schoolID = filter_input(INPUT_POST,'schoolIDSend');
$fact = TRUE;
$turnOffSchool = FALSE;
$dateExit = date("Y-m-d H:i:s");
$person = $_SESSION["user"];

$queryCheck = 'SELECT *
               FROM school_list
               WHERE schoolID = :schoolID;';
$statementGetSchool = $db->prepare($queryCheck);
$statementGetSchool->bindValue(':schoolID', $schoolID);
$statementGetSchool->execute();
$getSchoolMatch = $statementGetSchool->fetch();
$statementGetSchool->closeCursor();

$queryDelete = 'UPDATE deleted_schools SET
delete_fact =:fact, delete_history =:dateExit, user_stamp =:person
WHERE
schoolID = :schoolID;';
$statementDeleteSchoolName = $db->prepare($queryDelete);
$statementDeleteSchoolName->bindValue(':fact', $fact);
$statementDeleteSchoolName->bindValue(':dateExit', $dateExit);
$statementDeleteSchoolName->bindValue(':person', $person);
$statementDeleteSchoolName->bindValue(':schoolID', $schoolID);
$statementDeleteSchoolName->execute();
$statementDeleteSchoolName->closeCursor();

$queryTurnOff = 'UPDATE school_list SET
on_off =:turnOffSchool
WHERE
schoolID = :schoolID;';
$statementTurnOff = $db->prepare($queryTurnOff);
$statementTurnOff->bindValue(':turnOffSchool', $turnOffSchool);
$statementTurnOff->bindValue(':schoolID', $schoolID);
$statementTurnOff->execute();
$statementTurnOff->closeCursor();


header('Location: http://192.168.2.157/volunteer/Schools.php');
exit();
?>