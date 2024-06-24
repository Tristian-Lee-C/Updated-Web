<?php
session_start();
require_once('database.php');

if(isset($_GET['SCodeID'])) {
    $grabID = $_GET['SCodeID'];
}
if(isset($_GET['isChecked'])) {
    // Get the value of the isChecked parameter
    $isChecked = $_GET['isChecked'];
    
    // Debugging output to check the value of isChecked
    echo "isChecked value: " . $isChecked . "<br>";
    
    // Perform actions based on the checkbox state
    if($isChecked == 'true') {
        // Checkbox is checked, perform some action
        // For example, update a PHP variable
        $switchBoolean = 1;
    } else {
        // Checkbox is unchecked, perform some other action
        // For example, reset the PHP variable
        $switchBoolean = 0;
    }
    
    // Debugging output to check the value of $switchBoolean
    echo "switchBoolean value: " . $switchBoolean . "<br>";

	$queryStaff = 'SELECT *
					FROM service_code';
	$statementStaff = $db->prepare($queryStaff);
	$statementStaff->execute();
	$StaffSingle = $statementStaff->fetchAll();
	$statementStaff->closeCursor();

    // Attempt to update the database
    try {
        // Your SQL query for updating the database
        $queryActive = "UPDATE service_code 
                        SET on_off=:switchBoolean 
                        WHERE service_codeID=:grabID;";
        
        // Prepare and execute the SQL query
        $activeStatement = $db->prepare($queryActive);
        $activeStatement->bindValue(':switchBoolean', $switchBoolean);
        $activeStatement->bindValue(':grabID', $grabID);
        $activeStatement->execute();
        $activeStatement->closeCursor();
        
        // Output success message
        echo "Database updated successfully.";
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error updating database: " . $e->getMessage();
    }
} else {
    // Output error message if isChecked parameter is not set
    echo "Error: isChecked parameter not set.";
}

?>