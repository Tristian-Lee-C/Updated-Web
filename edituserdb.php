<?php
    $volunteerID = filter_input(INPUT_POST,'volunteerID');
    $firstName = filter_input(INPUT_POST,'firstName');
    $lastName = filter_input(INPUT_POST,'lastName');
    $email = filter_input(INPUT_POST,'email');
    $phoneRaw = filter_input(INPUT_POST,'phone');
    $phone = preg_replace('/[^0-9]/',"", $phoneRaw);
    $volunteerType = filter_input(INPUT_POST,'volunteer_types');
    $campuses = $_POST['school_names'];
    $birthday = filter_input(INPUT_POST,'birthday');
    $yearCatch = date('Y');
    //optional values//
    $street = filter_input(INPUT_POST,'street');
    $city = filter_input(INPUT_POST,'city');
    $stateAddress = filter_input(INPUT_POST,'state');
    $zip = filter_input(INPUT_POST,'zip');
    $county = filter_input(INPUT_POST,'county');
    require_once('database.php');

    $query = 'UPDATE volunteer_name SET
                volunteer_first_name=:firstName, volunteer_last_name=:lastName, volunteer_email=:email, volunteer_phone=:phone, birth_date=:birthday, street=:street, city=:city, state_address=:stateAddress, zip=:zip, county=:county
                WHERE
                volunteerID = :volunteerID;';
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
    $statement->bindValue(':volunteerID', $volunteerID);
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
    volunteerID = :volunteerID;';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerTypeIDCatch', $volunteerTypeIDCatch);
    $statement->bindValue(':volunteerID', $volunteerID);
    $statement->execute();
    $statement->closeCursor();

    $query = 'SELECT * 
                FROM school_queue 
                INNER JOIN school_list ON school_list.schoolID = school_queue.schoolID
                WHERE volunteerID = :volunteerID';
    $statement = $db->prepare($query);
    $statement->bindValue(':volunteerID', $volunteerID);
    $statement->execute();
    $lists = $statement->fetchAll();
    $statement->closeCursor();

    //foreach($lists as $list){
        $query = 'DELETE FROM school_queue 
                    WHERE volunteerID = :volunteerID';
            $statement = $db->prepare($query);
            $statement->bindValue(':volunteerID', $volunteerID);
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
                (:volunteerID, :schoolIDCatch, :yearCatch);';
                $statement = $db->prepare($query);
                $statement->bindValue(':volunteerID', $volunteerID);
                $statement->bindValue(':schoolIDCatch', $schoolIDCatch);
                $statement->bindValue(':yearCatch', $yearCatch);
                $statement->execute();
                $statement->closeCursor();
            }

        
    //}

    header('Location: http://192.168.2.157/volunteer/Home.php');
    exit();

?>