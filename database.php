<?php
    $dsn = 'mysql:host=127.0.0.1;dbname=volunteer_database';
    $username = 'cish@tDevelopment';
    $password = 'cishotAu5t1n';

    try{
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e)   {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>