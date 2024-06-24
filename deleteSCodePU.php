<?php
require_once('serviceTool.php');

$scodeName = filter_input(INPUT_POST,'SCodeIDDelete');

$queryCheck = 'SELECT *
               FROM service_code
               WHERE service_codeID = :scodeName;';
$statementSCode = $db->prepare($queryCheck);
$statementSCode->bindValue(':scodeName', $scodeName);
$statementSCode->execute();
$getScodeMatch = $statementSCode->fetch();
$statementSCode->closeCursor();


?>
    <head>
        <link rel="stylesheet" href="deletescodepu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="deleteSCodePopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Delete a Service Code</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="serviceTool.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="deleteSCodeButtonPopUp" action="deletescodedb.php" method="POST">
                    <label class='scodeText'>Confirm Deletion of <?php echo $getScodeMatch['service_code']; ?>? </label>
                    <input type='hidden' name='scodeIDSend' value='<?php echo $scodeName;?>'>
                    <input type='submit' value='YES' name='deleteSCode' class='deleteSCodeButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>