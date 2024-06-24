<?php
    $staffID = filter_input(INPUT_POST,'staffIDEdit');
    $firstName = filter_input(INPUT_POST,'firstName');
    $lastName = filter_input(INPUT_POST,'lastName');
    $email = filter_input(INPUT_POST,'email');
    $phoneRaw = filter_input(INPUT_POST,'phone');
    $phone = preg_replace('/[^0-9]/',"", $phoneRaw);
    $birthday = filter_input(INPUT_POST,'birthday');
    //optional values//
    $street = filter_input(INPUT_POST,'street');
    $city = filter_input(INPUT_POST,'city');
    $stateAddress = filter_input(INPUT_POST,'state');
    $zip = filter_input(INPUT_POST,'zip');
    $county = filter_input(INPUT_POST,'county');
    $role_type = filter_input(INPUT_POST,'role_type');
    require_once('database.php');

    $query = 'UPDATE staff_name SET
                first_name=:firstName, last_name=:lastName, email_address=:email, phone_number=:phone, date_of_birth=:birthday, street=:street, city=:city, state_address=:stateAddress, zip=:zip, county=:county
                WHERE
                staff_ID = :staffID;';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':birthday', $birthday);
    $statement->bindValue(':street', $street);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':stateAddress', $stateAddress);
    $statement->bindValue(':zip', $zip);
    $statement->bindValue(':county', $county);
    $statement->bindValue(':staffID', $staffID);
    $statement->execute();
    $statement->closeCursor();

    $query = 'UPDATE staff_login SET
    staff_email=:email, user_role=:role_type
    WHERE
    staff_ID = :staffID;';
    $statementLS = $db->prepare($query);
    $statementLS->bindValue(':role_type', $role_type);
    $statementLS->bindValue(':email', $email);
    $statementLS->bindValue(':staffID', $staffID);
    $statementLS->execute();
    $statementLS->closeCursor();

    header('Location: http://192.168.2.157/volunteer/Staff.php');
    exit();

?>