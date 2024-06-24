<?php
	session_start();
	$ID = filter_input(INPUT_POST,'ID');
	$firstName = filter_input(INPUT_POST,'firstName');
    $lastName = filter_input(INPUT_POST,'lastName');
    $email = filter_input(INPUT_POST,'email');
    $phoneRaw = filter_input(INPUT_POST,'phone');
    $phone = preg_replace('/[^0-9]/',"", $phoneRaw);
	$birthday = filter_input(INPUT_POST,'birthday');
    //optional values//
    $street = filter_input(INPUT_POST,'street');
    $stateAddress = filter_input(INPUT_POST,'state');
    $zip = filter_input(INPUT_POST,'zip');
    $county = filter_input(INPUT_POST,'county');
	$city = filter_input(INPUT_POST,'city');

    require_once('database.php');

    if (isset($_SESSION["is_administator"]) || isset($_SESSION["is_moderator"])){

        $query = 'UPDATE staff_name
                    SET first_name=:firstName, last_name=:lastName, email_address=:email, phone_number=:phone, date_of_birth=:birthday, street=:street, state_address=:stateAddress, zip=:zip, county=:county, city=:city
                    WHERE staff_ID=:ID;';
            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':phone', $phone);
            $statement->bindValue(':birthday', $birthday);
            $statement->bindValue(':street', $street);
            $statement->bindValue(':stateAddress', $stateAddress);
            $statement->bindValue(':zip', $zip);
            $statement->bindValue(':county', $county);
            $statement->bindValue(':city', $city);
            $statement->bindValue(':ID', $ID);
            $statement->execute();
            $statement->closeCursor();
    }
    elseif(!isset($_SESSION["is_administator"]) && !isset($_SESSION["is_moderator"]) && isset($_SESSION["is_user"])){
        $query = 'UPDATE volunteer_name
        SET volunteer_first_name=:firstName, volunteer_last_name=:lastName, volunteer_email=:email, volunteer_phone=:phone, birth_date=:birthday, street=:street, state_address=:stateAddress, zip=:zip, county=:county, city=:city
        WHERE volunteerID=:ID;';
        $statement = $db->prepare($query);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':phone', $phone);
        $statement->bindValue(':birthday', $birthday);
        $statement->bindValue(':street', $street);
        $statement->bindValue(':stateAddress', $stateAddress);
        $statement->bindValue(':zip', $zip);
        $statement->bindValue(':county', $county);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':ID', $ID);
        $statement->execute();
        $statement->closeCursor();
    };


        


    header('Location: http://192.168.2.157/volunteer/Profile.php');
    exit();

?>