<?php
session_start();
require_once('database.php');

$sCodeName = filter_input(INPUT_POST,'scodeName');
$sCodeID = filter_input(INPUT_POST,'scodeIDSend');

$queryCheck = 'SELECT *
               FROM service_code
               WHERE service_code = :sCodeName;';
$statementGetSCode = $db->prepare($queryCheck);
$statementGetSCode->bindValue(':sCodeName', $sCodeName);
$statementGetSCode->execute();
$getSCodeMatch = $statementGetSCode->fetch();
$statementGetSCode->closeCursor();

if(empty($getSCodeMatch))
{

    $queryEdits = 'UPDATE service_code SET
    service_code =:sCodeName
    WHERE
    service_codeID = :sCodeID;';
    $statementEditSCode = $db->prepare($queryEdits);
    $statementEditSCode->bindValue(':sCodeName', $sCodeName);
    $statementEditSCode->bindValue(':sCodeID', $sCodeID);
    $statementEditSCode->execute();
    $statementEditSCode->closeCursor();


    header('Location: http://192.168.2.157/volunteer/serviceTool.php');
    exit();
}

header('Location: http://192.168.2.157/volunteer/serviceTool.php');
exit();
?>