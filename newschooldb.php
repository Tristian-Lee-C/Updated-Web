<?php
session_start();
require_once('database.php');

$schoolName = filter_input(INPUT_POST,'schoolName');

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
    $queryCreateSchool = 'INSERT INTO school_list
    (school_name)
    VALUES
    (:schoolName)';
    $statementCreateSchool = $db->prepare($queryCreateSchool);
    $statementCreateSchool->bindValue(':schoolName', $schoolName);
    $statementCreateSchool->execute();
    $statementCreateSchool->closeCursor();

    $queryGetID = 'SELECT *
               FROM school_list
               WHERE school_name = :schoolName;';
    $statementGetSchoolID = $db->prepare($queryGetID);
    $statementGetSchoolID->bindValue(':schoolName', $schoolName);
    $statementGetSchoolID->execute();
    $getSchoolID = $statementGetSchoolID->fetch();
    $statementGetSchoolID->closeCursor();

    $schoolID = $getSchoolID['schoolID'];

    $queryCreateSchool = 'INSERT INTO deleted_schools
    (schoolID)
    VALUES
    (:schoolID)';
    $statementCreateSchool = $db->prepare($queryCreateSchool);
    $statementCreateSchool->bindValue(':schoolID', $schoolID);
    $statementCreateSchool->execute();
    $statementCreateSchool->closeCursor();




    header('Location: http://192.168.2.157/volunteer/Schools.php');
    exit();
}

header('Location: http://192.168.2.157/volunteer/Schools.php');
exit();
?>