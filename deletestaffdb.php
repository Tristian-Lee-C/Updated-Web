<?php
    $staff_delete_id = filter_input(INPUT_POST,'staffIDDelete');
    $exit_type = filter_input(INPUT_POST,'exit_type');
    $comment = filter_input(INPUT_POST,'exitParagraphComment');
    $exitFact = TRUE;
    $dateExit = date("Y-m-d H:i:s");
    session_start();
    $person = $_SESSION["user"];
    require_once('database.php');

    $querySearch = 'SELECT *
                    FROM delete_staff_reason
                    WHERE delete_staff_reason = :exit_type';
    $statementSearch = $db->prepare($querySearch);
    $statementSearch->bindValue(':exit_type', $exit_type);
    $statementSearch->execute();
    $reasonCodes = $statementSearch->fetch();
    $reasonCatch = $reasonCodes['delete_staff_reasonID'];
    $statementSearch->closeCursor();

    $queryExitE = 'UPDATE deleted_staff SET
    delete_fact=:exitFact, delete_reason=:reasonCatch, staff_comment=:comment, delete_history=:dateExit, user_stamp=:person
    WHERE
    staff_ID = :staff_delete_id';
    $statementExitE = $db->prepare($queryExitE);
    $statementExitE->bindValue(':staff_delete_id', $staff_delete_id);
    $statementExitE->bindValue(':exitFact', $exitFact);
    $statementExitE->bindValue(':reasonCatch', $reasonCatch);
    $statementExitE->bindValue(':comment', $comment);
    $statementExitE->bindValue(':person', $person);
    $statementExitE->bindValue(':dateExit', $dateExit);
    $statementExitE->execute();
    $statementExitE->closeCursor();

    header('Location: http://192.168.2.157/volunteer/Staff.php');

?>

<html>
    <?php echo $staff_delete_id; ?>
</html>