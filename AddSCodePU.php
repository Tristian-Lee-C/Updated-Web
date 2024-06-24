<?php
require_once('serviceTool.php');
?>
    <head>
        <link rel="stylesheet" href="addscodepu_template.css">
    </head>
    <div class = "grayOutZone">
        <div class = "centeringZone">
            <div class="addSCodePopUpForm">
                <div class="topBar">
                    <a class='topBarText'>Add a Service Code</a>
                    <a class='topBarSpace'></a>
                    <a class='topBarX' href="serviceTool.php">&#215;</a>
                </div>
                <div class="informationBar">
                <form class ="addSCodeButtonPopUp" action="newscodedb.php" method="POST">
                    <label class='scodeText'>Service Code:
							<input type="text" name="scodeName" required>
					</label>
                    <input type="submit" value="Add" name='addSCode' class='addSCodeButtonPU'>
                </form>
                </div>
            </div>
        </div>
    </div>