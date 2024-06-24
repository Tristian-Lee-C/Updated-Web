<?php
    $ServiceIDSelect = filter_input(INPUT_POST, 'serviceID');
    $ServiceSchoolSelect = filter_input(INPUT_POST, 'schoolChoice');
    $ServiceStudentNameSelect = filter_input(INPUT_POST, 'studentNamesBox');
    $ServiceTimeSelect = filter_input(INPUT_POST, 'serviceTime');
    $ServiceCodeSelect = filter_input(INPUT_POST, 'serviceCodeChoice');
    $ServiceTierSelect = filter_input(INPUT_POST, 'serviceTypeChoice');
    $ServiceCommentSelect = filter_input(INPUT_POST, 'serviceComment');
    $ServiceDateSelect = filter_input(INPUT_POST, 'serviceDate');
    require_once('database.php');

    $querySchool = 'SELECT schoolID
                    FROM school_list
                    WHERE school_name =:ServiceSchoolSelect';
    $statementSchool = $db->prepare($querySchool);
    $statementSchool->bindValue(':ServiceSchoolSelect', $ServiceSchoolSelect);
    $statementSchool->execute();
    $serviceSchool = $statementSchool->fetch();
    $statementSchool->closeCursor();

    $SchoolGet = $serviceSchool['schoolID'];

    $queryCode = 'SELECT service_codeID
                    FROM service_code
                    WHERE service_code =:ServiceCodeSelect';
    $statementCode = $db->prepare($queryCode);
    $statementCode->bindValue(':ServiceCodeSelect', $ServiceCodeSelect);
    $statementCode->execute();
    $serviceCode = $statementCode->fetch();
    $statementCode->closeCursor();

    $CodeGet = $serviceCode['service_codeID'];

    $queryTier = 'SELECT tierID
                  FROM tier_level_type
                  WHERE tier_level =:ServiceTierSelect';
    $statementTier = $db->prepare($queryTier);
    $statementTier->bindValue(':ServiceTierSelect', $ServiceTierSelect);
    $statementTier->execute();
    $serviceTier = $statementTier->fetch();
    $statementTier->closeCursor();

    $TierGet = $serviceTier['tierID'];

    $query = 'UPDATE service_entry SET 
              service_date=:ServiceDateSelect, service_minutes=:ServiceTimeSelect, student_names=:ServiceStudentNameSelect, service_comment=:ServiceCommentSelect, tierID=:TierGet, service_codeID=:CodeGet, schoolID=:SchoolGet
              WHERE serviceID =:ServiceIDSelect';
    $statement = $db->prepare($query);
    $statement->bindValue(':ServiceDateSelect', $ServiceDateSelect);
    $statement->bindValue(':ServiceTimeSelect', $ServiceTimeSelect);
    $statement->bindValue(':ServiceStudentNameSelect', $ServiceStudentNameSelect);
    $statement->bindValue(':ServiceCommentSelect', $ServiceCommentSelect);
    $statement->bindValue(':TierGet', $TierGet);
    $statement->bindValue(':CodeGet', $CodeGet);
    $statement->bindValue(':SchoolGet', $SchoolGet);
    $statement->bindValue(':ServiceIDSelect', $ServiceIDSelect);
    $statement->execute();
    $statement->closeCursor();




    /*$query = 'UPDATE volunteer_name SET
                volunteer_first_name=:firstName, volunteer_last_name=:lastName, volunteer_email=:email, volunteer_phone=:phone
                WHERE
                volunteerID = :volunteerID;';
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':volunteerID', $volunteerID);
    $statement->execute();
    $statement->closeCursor();*/



    header('Location: http://192.168.2.157/volunteer/Services.php');
    exit();

?>


