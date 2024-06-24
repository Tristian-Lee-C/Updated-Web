<?php
    $volunteerID = filter_input(INPUT_POST, 'volunteer');
    $schoolChoice = filter_input(INPUT_POST, 'schoolChoice');
    $studentNames = filter_input(INPUT_POST, 'studentNamesBox');
    $serviceTime = filter_input(INPUT_POST, 'serviceTime');
    $serviceCode = filter_input(INPUT_POST, 'serviceCodeChoice');
    $serviceType = filter_input(INPUT_POST, 'serviceTypeChoice');
    $serviceComment = filter_input(INPUT_POST, 'serviceComment');
    $serviceDate = filter_input(INPUT_POST, 'serviceDate');
    $staff = filter_input(INPUT_POST, 'staffEntry');

    require_once('database.php');

    $querySchool = 'SELECT * FROM school_list WHERE school_name =:schoolChoice';
    $statementSchool = $db->prepare($querySchool);
    $statementSchool->bindValue(':schoolChoice', $schoolChoice);
    $statementSchool->execute();
    $school = $statementSchool->fetch();
    $schoolCatch = $school['schoolID'];
    $statementSchool->closeCursor();

    $querySC = 'SELECT * FROM service_code WHERE service_code =:serviceCode';
    $statementSC = $db->prepare($querySC);
    $statementSC->bindValue(':serviceCode', $serviceCode);
    $statementSC->execute();
    $SC = $statementSC->fetch();
    $codeCatch = $SC['service_codeID'];
    $statementSC->closeCursor();

    $queryTL = 'SELECT * FROM tier_level_type WHERE tier_level =:serviceType';
    $statementTL = $db->prepare($queryTL);
    $statementTL->bindValue(':serviceType', $serviceType);
    $statementTL->execute();
    $TL = $statementTL->fetch();
    $tierCatch = $TL['tierID'];
    $statementTL->closeCursor();

    $query = 'INSERT INTO service_entry
    (service_date, volunteerID, service_minutes, student_names, service_comment, tierID, service_codeID, schoolID, user_stamp)
    VALUES
    (:serviceDate, :volunteerID, :serviceTime, :studentNames, :serviceComment, :tierCatch, :codeCatch, :schoolCatch, :staff);';
    $statement = $db->prepare($query);
    $statement->bindValue(':serviceDate', $serviceDate);
    $statement->bindValue(':volunteerID', $volunteerID);
    $statement->bindValue(':serviceTime', $serviceTime);
    $statement->bindValue(':studentNames', $studentNames);
    $statement->bindValue(':serviceComment', $serviceComment);
    $statement->bindValue(':tierCatch', $tierCatch);
    $statement->bindValue(':codeCatch', $codeCatch);
    $statement->bindValue(':schoolCatch', $schoolCatch);
    $statement->bindValue(':staff', $staff);
    $statement->execute();
    $statement->closeCursor();

    $querySID = 'SELECT serviceID
                 FROM service_entry
                 WHERE service_date=:serviceDate AND volunteerID=:volunteerID AND service_minutes=:serviceTime AND student_names=:studentNames AND tierID=:tierCatch AND service_codeID=:codeCatch AND schoolID=:schoolCatch AND entry_date <= NOW() AND user_stamp=:staff';
    $statementSID = $db->prepare($querySID);
    $statementSID->bindValue(':serviceDate', $serviceDate);
    $statementSID->bindValue(':volunteerID', $volunteerID);
    $statementSID->bindValue(':serviceTime', $serviceTime);
    $statementSID->bindValue(':studentNames', $studentNames);
    $statementSID->bindValue(':tierCatch', $tierCatch);
    $statementSID->bindValue(':codeCatch', $codeCatch);
    $statementSID->bindValue(':schoolCatch', $schoolCatch);
    $statementSID->bindValue(':staff', $staff);
    $statementSID->execute();
    $ServiceIDs = $statementSID->fetch();
    $serviceID = $ServiceIDs['serviceID'];
    $statementSID->closeCursor();


    $deleteFact = FALSE;

    $queryDeleteS = 'INSERT INTO deleted_services
    (serviceID, delete_fact)
    VALUES
    (:serviceID, :deleteFact)';
    $statementDeleteS = $db->prepare($queryDeleteS);
    $statementDeleteS->bindValue(':serviceID', $serviceID);
    $statementDeleteS->bindValue(':deleteFact', $deleteFact);
    $statementDeleteS->execute();
    $statementDeleteS->closeCursor();

    header('Location: http://192.168.2.157/volunteer/Services.php');
    exit();
?>