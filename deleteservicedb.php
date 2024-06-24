<?php
    require_once('database.php');
    $volunteerID = filter_input(INPUT_POST, 'volunteerID');
    $serviceID = filter_input(INPUT_POST, 'serviceID');
    $deleteFact = True;
    $deleteChoice = filter_input(INPUT_POST, 'exit_dropdown');
    $deleteComment = filter_input(INPUT_POST, 'exitParagraphComment');
    $deleteDate = date("Y-m-d H:i:s");
    session_start();
    $person = $_SESSION["user"];

    $queryChoice = 'SELECT delete_reasonID
                    FROM delete_reason_table
                    WHERE delete_reasonID =:deleteChoice';
    $statementChoice = $db->prepare($queryChoice);
    $statementChoice->bindValue(':deleteChoice', $deleteChoice);
    $statementChoice->execute();
    $ChoiceGet = $statementChoice->fetch();
    $statementChoice->closeCursor();


    $query = 'UPDATE deleted_services SET 
    delete_fact=:deleteFact, delete_reasonID=:ChoiceGet, delete_comment=:deleteComment, delete_date=:deleteDate, user_stamp=:person
    WHERE serviceID =:serviceID';
    $statement = $db->prepare($query);
    $statement->bindValue(':deleteFact', $deleteFact);
    $statement->bindValue(':ChoiceGet', $ChoiceGet);
    $statement->bindValue(':deleteComment', $deleteComment);
    $statement->bindValue(':deleteDate', $deleteDate);
    $statement->bindValue(':person', $person);
    $statement->bindValue(':serviceID', $serviceID);
    $statement->execute();
    $statement->closeCursor();

    header('Location: http://192.168.2.157/volunteer/Services.php');
    exit();
?>