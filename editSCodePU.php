<?php
require_once('serviceTool.php');

$sCodeName = filter_input(INPUT_POST,'SCodeIDEdit');

$queryCheck = 'SELECT *
               FROM service_code
               WHERE service_codeID = :sCodeName;';
$statementGetSCode = $db->prepare($queryCheck);
$statementGetSCode->bindValue(':sCodeName', $sCodeName);
$statementGetSCode->execute();
$getSCodeMatch = $statementGetSCode->fetch();
$statementGetSCode->closeCursor();


?>
    <head>
        <link rel="stylesheet" href="editscodepu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="editSCodePopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Edit a Service Code</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="serviceTool.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="editSCodeButtonPopUp" action="editscodedb.php" method="POST">
                    <label class='scodeText'>Service Code:
							<input type="text" name="scodeName" value='<?php echo $getSCodeMatch['service_code'];?>'required>
					</label>
                    <input type='hidden' name='scodeIDSend' value='<?php echo $sCodeName;?>'>
                    <input type="submit" value="Edit" name='editSCode' class='editSCodeButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>