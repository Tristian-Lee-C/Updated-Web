<?php
    session_start();
    $_SESSION['error'] = '';
    $firstName = filter_input(INPUT_POST,'firstName');
    $lastName = filter_input(INPUT_POST,'lastName');
    $email = filter_input(INPUT_POST,'email');
    $phoneRaw = filter_input(INPUT_POST,'phone');
    $phone = preg_replace('/[^0-9]/',"", $phoneRaw);
    $volunteerType = filter_input(INPUT_POST,'volunteer_types');
    $yearCatch = date('Y');
    $campuses = $_POST['school_names'];
    $birthday = filter_input(INPUT_POST,'birthday');
    //optional values//
    $street = filter_input(INPUT_POST,'street');
    $city = filter_input(INPUT_POST,'city');
    $stateAddress = filter_input(INPUT_POST,'state');
    $zip = filter_input(INPUT_POST,'zip');
    $county = filter_input(INPUT_POST,'county');
    require_once('database.php');

    $emailquery='SELECT volunteer_email
                FROM volunteer_login
                WHERE volunteer_email=:email';
    $statement = $db->prepare($emailquery);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $checkEmail = $statement->fetch();
    $statement->closeCursor();


    if(empty($checkEmail)){
    $query = 'SELECT volunteer_year.volunteerYear
                FROM volunteer_name 
                INNER JOIN volunteer_year_queue ON volunteer_year_queue.volunteerID = volunteer_name.volunteerID
                INNER JOIN volunteer_year ON volunteer_year.yearID = volunteer_year_queue.yearID
                WHERE volunteer_first_name = :firstName AND volunteer_last_name = :lastName AND birth_date=:birthday';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':birthday', $birthday);
    $statement->execute();
    $checkName = $statement->fetch();
    $statement->closeCursor();

    $checkquery = 'SELECT *
                    FROM volunteer_name
                    INNER JOIN exit_list on exit_list.volunteerID = volunteer_name.volunteerID
                    WHERE volunteer_first_name = :firstName AND volunteer_last_name = :lastName AND birth_date=:birthday';
    $statementCheck = $db->prepare($checkquery);
    $statementCheck->bindValue(':firstName', $firstName);
    $statementCheck->bindValue(':lastName', $lastName);
    $statementCheck->bindValue(':birthday', $birthday);
    $statementCheck->execute();
    $checkNameVol = $statementCheck->fetch();
    if(!empty($checkNameVol)){
    $Revive = $checkNameVol['exit_fact'];
    $volunteer_id = $checkNameVol['volunteerID'];
    };
    $statementCheck->closeCursor();


    if(empty($checkName)){

    $query = 'INSERT INTO volunteer_name
                (volunteer_first_name, volunteer_last_name, volunteer_email, volunteer_phone, birth_date, street, city, state_address, zip, county)
                VALUES
                (:firstName, :lastName, :email, :phone, :birthday, :street, :city, :stateAddress, :zip, :county);';
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
    $statement->execute();
    $statement->closeCursor();

    $query = 'SELECT volunteer_name.volunteerID
              FROM volunteer_name 
              WHERE volunteer_first_name = :firstName AND volunteer_last_name = :lastName AND birth_date=:birthday';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':birthday', $birthday);
    $statement->execute();
    $recentAddName = $statement->fetch();
    $volunteerIDCatch = $recentAddName['volunteerID'];
    $statement->closeCursor();

    $query = 'SELECT * FROM volunteer_year WHERE volunteerYear = :yearCatch';
    $statement = $db->prepare($query);
    $statement->bindValue(':yearCatch', $yearCatch);
    $statement->execute();
    $recentYear = $statement->fetch();
    if($recentYear != NULL){
        $yearIDCatch = $recentYear['yearID'];
    };
    $statement->closeCursor();

    $query = 'SELECT * FROM volunteer_type WHERE volunteer_type = :volunteerType';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerType', $volunteerType);
    $statement->execute();
    $recentVolunteerType = $statement->fetch();
    $volunteerTypeIDCatch = $recentVolunteerType['volunteer_typeID'];
    $statement->closeCursor();

    $query = 'INSERT INTO volunteer_type_history
    (volunteerID, volunteer_typeID)
    VALUES
    (:volunteerIDCatch, :volunteerTypeIDCatch);';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->bindValue(':volunteerTypeIDCatch', $volunteerTypeIDCatch);
    $statement->execute();
    $statement->closeCursor();

    foreach ($campuses as $campus){
        $query = 'SELECT * FROM school_list WHERE school_name = :campus';
        $statement = $db->prepare($query);
        $statement->bindValue(':campus', $campus);
        $statement->execute();
        $recentSchool = $statement->fetch();
        $schoolIDCatch = $recentSchool['schoolID'];
        $statement->closeCursor();

        $query = 'INSERT INTO school_queue
        (volunteerID, schoolID, location_date)
        VALUES
        (:volunteerIDCatch, :schoolIDCatch, :yearCatch);';
        $statement = $db->prepare($query);
        $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
        $statement->bindValue(':schoolIDCatch', $schoolIDCatch);
        $statement->bindValue(':yearCatch', $yearCatch);
        $statement->execute();
        $statement->closeCursor();

        $passwordTemp = '$2y$10$GF04RW3LegPWMajeM2FXZuHBvM690kTX5.g5JlFi3O/ruiZdqEVwW';
        $roleSet = 3;
        $query = 'INSERT INTO volunteer_login
                  (volunteer_email, volunteer_password, user_role, volunteerID)
                  VALUES
                  (:email, :passwordTemp, :roleSet, :volunteerIDCatch)';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':passwordTemp', $passwordTemp);
        $statement->bindValue(':roleSet', $roleSet);
        $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
        $statement->execute();
        $statement->closeCursor();
    }

    if(empty($recentYear['yearID'])){
        $query = 'INSERT INTO volunteer_year
        (volunteerYear)
        VALUES
        (:yearCatch);';
        $statement = $db->prepare($query);
        $statement->bindValue(':yearCatch', $yearCatch);
        $statement->execute();
        $statement->closeCursor();

        $query = 'SELECT * FROM volunteer_year WHERE volunteerYear = :yearCatch';
        $statement = $db->prepare($query);
        $statement->bindValue(':yearCatch', $yearCatch);
        $statement->execute();
        $recentYear = $statement->fetch();
        $yearIDCatch = $recentYear['yearID'];
        $statement->closeCursor();
    }

    $query = 'INSERT INTO volunteer_year_queue
    (volunteerID, yearID)
    VALUES
    (:volunteerIDCatch, :yearIDCatch);';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->bindValue(':yearIDCatch', $yearIDCatch);
    $statement->execute();
    $statement->closeCursor();

    $exitFact = FALSE;

    $queryExitE = 'INSERT INTO exit_list
    (volunteerID, exit_fact)
    VALUES
    (:volunteerIDCatch, :exitFact)';
    $statementExitE = $db->prepare($queryExitE);
    $statementExitE->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statementExitE->bindValue(':exitFact', $exitFact);
    $statementExitE->execute();
    $exit_id = $statementExitE->fetch();
    $exitCatch = $exit_id['exit_id'];
    $statementExitE->closeCursor();

    header('Location: http://192.168.2.157/volunteer/Home.php');
    exit();
}
elseif (!empty($checkName) && $checkName['volunteerYear'] < $yearCatch) {
    $yearGrab = $checkName['volunteerYear'];

    $query = 'SELECT volunteer_name.volunteerID
    FROM volunteer_name 
    INNER JOIN volunteer_year_queue ON volunteer_year_queue.volunteerID = volunteer_name.volunteerID
    INNER JOIN volunteer_year ON volunteer_year.yearID = volunteer_year_queue.yearID
    WHERE volunteer_first_name = :firstName AND volunteer_last_name = :lastName AND birth_date=:birthday AND volunteerYear=:yearGrab';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':birthday', $birthday);
    $statement->bindValue(':yearGrab', $yearGrab);
    $statement->execute();
    $recentAddName = $statement->fetch();
    $volunteerIDCatch = $recentAddName['volunteerID'];
    $statement->closeCursor();


    $query = 'SELECT * FROM volunteer_year WHERE volunteerYear = :yearCatch';
    $statement = $db->prepare($query);
    $statement->bindValue(':yearCatch', $yearCatch);
    $statement->execute();
    $recentYear = $statement->fetch();
    if($recentYear != NULL){
        $yearIDCatch = $recentYear['yearID'];
    };
    $statement->closeCursor();


    $query = 'UPDATE volunteer_year_queue SET 
     yearID=:yearIDCatch
    WHERE
    volunteerID=:volunteerIDCatch;';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->bindValue(':yearIDCatch', $yearIDCatch);
    $statement->execute();
    $statement->closeCursor();

    $query = 'UPDATE volunteer_name SET
                volunteer_first_name=:firstName, volunteer_last_name=:lastName, volunteer_email=:email, volunteer_phone=:phone, birth_date=:birthday, street=:street, city=:city, state_address=:stateAddress, zip=:zip, county=:county
                WHERE
                volunteerID = :volunteerIDCatch;';
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
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->execute();
    $statement->closeCursor();


    header('Location: http://192.168.2.157/volunteer/Home.php');
    exit();
}
elseif(!empty($checkName) && (bool)$Revive == True){
    $query = 'SELECT volunteer_name.volunteerID
    FROM volunteer_name 
    WHERE volunteer_first_name = :firstName AND volunteer_last_name = :lastName AND birth_date=:birthday';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':birthday', $birthday);
    $statement->execute();
    $recentAddName = $statement->fetch();
    $volunteerIDCatch = $recentAddName['volunteerID'];
    $statement->closeCursor();

    $exitFact = '0';
    $reasonCatch = NULL;
    $comment = NULL;
    $person = NULL;
    $dateExit = NULL;
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

    $query = 'UPDATE volunteer_name SET
    volunteer_first_name=:firstName, volunteer_last_name=:lastName, volunteer_email=:email, volunteer_phone=:phone, birth_date=:birthday, street=:street, city=:city, state_address=:stateAddress, zip=:zip, county=:county
    WHERE
    volunteerID = :volunteerIDCatch;';
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
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->execute();
    $statement->closeCursor();

    $query = 'SELECT * FROM volunteer_type WHERE volunteer_type = :volunteerType';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerType', $volunteerType);
    $statement->execute();
    $recentVolunteerType = $statement->fetch();
    $volunteerTypeIDCatch = $recentVolunteerType['volunteer_typeID'];
    $statement->closeCursor();

    $query = 'UPDATE volunteer_type_history SET
    volunteer_typeID=:volunteerTypeIDCatch
    WHERE
    volunteerID = :volunteerIDCatch;';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->bindValue(':volunteerTypeIDCatch', $volunteerTypeIDCatch);
    $statement->execute();
    $statement->closeCursor();

    $query = 'DELETE FROM school_queue 
    WHERE volunteerID = :volunteerIDCatch';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
    $statement->execute();
    $statement->closeCursor();

    foreach ($campuses as $campus){
        $query = 'SELECT * FROM school_list WHERE school_name = :campus';
        $statement = $db->prepare($query);
        $statement->bindValue(':campus', $campus);
        $statement->execute();
        $recentSchool = $statement->fetch();
        $schoolIDCatch = $recentSchool['schoolID'];
        $statement->closeCursor();

        $query = 'INSERT INTO school_queue
        (volunteerID, schoolID, location_date)
        VALUES
        (:volunteerIDCatch, :schoolIDCatch, :yearCatch);';
        $statement = $db->prepare($query);
        $statement->bindValue(':volunteerIDCatch', $volunteerIDCatch);
        $statement->bindValue(':schoolIDCatch', $schoolIDCatch);
        $statement->bindValue(':yearCatch', $yearCatch);
        $statement->execute();
        $statement->closeCursor();
    }
    
    header('Location: http://192.168.2.157/volunteer/Home.php');
    exit();
}
else{
    $_SESSION['error'] = 'User is already registered';
    header('Location: http://192.168.2.157/volunteer/AddUser.php');
    exit();
}
}else{
    session_start();
    $_SESSION['error'] = 'Email is already registered';
    header('Location: http://192.168.2.157/volunteer/AddUser.php');
    exit();
}


?>
