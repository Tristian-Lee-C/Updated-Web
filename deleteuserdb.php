<?php
    $volunteer_id = filter_input(INPUT_POST,'volunteerID');
    $exit_Reason = filter_input(INPUT_POST,'exit_dropdown');
    $comment = filter_input(INPUT_POST,'exitParagraphComment');
    $exitFact = TRUE;
    $dateExit = date("Y-m-d H:i:s");
    session_start();
    $person = $_SESSION["user"];
    require_once('database.php');

    $querySearch = 'SELECT *
                    FROM reason_table
                    WHERE reason_Text = :exit_Reason';
    $statementSearch = $db->prepare($querySearch);
    $statementSearch->bindValue(':exit_Reason', $exit_Reason);
    $statementSearch->execute();
    $reasonCodes = $statementSearch->fetch();
    $reasonCatch = $reasonCodes['reasonID'];
    $statementSearch->closeCursor();

    $queryExitE = 'UPDATE exit_list SET
    exit_fact=:exitFact, exit_reason=:reasonCatch, comment=:comment, exit_date=:dateExit, user_stamp=:person
    WHERE
    volunteerID = :volunteer_id';
    $statementExitE = $db->prepare($queryExitE);
    $statementExitE->bindValue(':volunteer_id', $volunteer_id);
    $statementExitE->bindValue(':exitFact', $exitFact);
    $statementExitE->bindValue(':reasonCatch', $reasonCatch);
    $statementExitE->bindValue(':comment', $comment);
    $statementExitE->bindValue(':person', $person);
    $statementExitE->bindValue(':dateExit', $dateExit);
    $statementExitE->execute();
    $statementExitE->closeCursor();

    header('Location: http://192.168.2.157/volunteer/Home.php');

?>