<?php
session_start();
require_once('database.php');

$schoolName = filter_input(INPUT_POST,'schoolName');
$schoolID = filter_input(INPUT_POST,'schoolIDSend');

$queryCheck = 'SELECT *
               FROM school_list
               WHERE school_name = :schoolName;';
$statementGetSchool = $db->prepare($queryCheck);
$statementGetSchool->bindValue(':schoolName', $schoolName);
$statementGetSchool->execute();
$getSchoolMatch = $statementGetSchool->fetch();
$statementGetSchool->closeCursor();

if(empty($getSchoolMatch))
{

    $queryEdits = 'UPDATE school_list SET
    school_name =:schoolName
    WHERE
    schoolID = :schoolID;';
    $statementEditSchoolName = $db->prepare($queryEdits);
    $statementEditSchoolName->bindValue(':schoolName', $schoolName);
    $statementEditSchoolName->bindValue(':schoolID', $schoolID);
    $statementEditSchoolName->execute();
    $statementEditSchoolName->closeCursor();


    header('Location: http://192.168.2.157/volunteer/Schools.php');
    exit();
}

header('Location: http://192.168.2.157/volunteer/Schools.php');
exit();
?>