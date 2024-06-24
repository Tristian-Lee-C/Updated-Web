<?php
session_start();
require_once('database.php');

$scodeName = filter_input(INPUT_POST,'scodeName');

$queryCheck = 'SELECT *
               FROM service_code
               WHERE service_code = :scodeName;';
$statementGetSCode = $db->prepare($queryCheck);
$statementGetSCode->bindValue(':scodeName', $scodeName);
$statementGetSCode->execute();
$getSchoolMatch = $statementGetSCode->fetch();
$statementGetSCode->closeCursor();

if(empty($getSchoolMatch))
{
    $queryCreateSCode = 'INSERT INTO service_code
    (service_code)
    VALUES
    (:scodeName)';
    $statementCreateSCode = $db->prepare($queryCreateSCode);
    $statementCreateSCode->bindValue(':scodeName', $scodeName);
    $statementCreateSCode->execute();
    $statementCreateSCode->closeCursor();

    $queryGetID = 'SELECT *
               FROM service_code
               WHERE service_code = :scodeName;';
    $statementGetSCodeID = $db->prepare($queryGetID);
    $statementGetSCodeID->bindValue(':scodeName', $scodeName);
    $statementGetSCodeID->execute();
    $getSchoolID = $statementGetSCodeID->fetch();
    $statementGetSCodeID->closeCursor();

    $SCodeID = $getSchoolID['service_codeID'];

    $queryCreateSchool = 'INSERT INTO deleted_servicecode
    (service_codeID)
    VALUES
    (:SCodeID)';
    $statementCreateSCode = $db->prepare($queryCreateSchool);
    $statementCreateSCode->bindValue(':SCodeID', $SCodeID);
    $statementCreateSCode->execute();
    $statementCreateSCode->closeCursor();




    header('Location: http://192.168.2.157/volunteer/serviceTool.php');
    exit();
}

header('Location: http://192.168.2.157/volunteer/serviceTool.php');
exit();
?>