<?php

    // Database info
    $hostname = 'localhost';
    $dbname   = 'costa_rica_israel';
    $username = 'root';
    $password = '';

    // email address to send errors
    $adminEmail = "costaricaisraelassociation@gmail.com";

    function makeConnection() {
        global $hostname,$dbname,$username,$password;

        $con = new PDO("mysql:host=$hostname;dbname=$dbname",$username,$password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $con;
    }

    function prepareAndExecuteQuery($con, $sql) {
        try {
            $statement = $con->prepare($sql);
            $statement->execute();

            $result = $statement->fetchAll();

        } catch (PDOException $e) {
            var_dump($e->getMessage());
            mail(getAdminEmail(), "DB ERROR: " . $e->getCode(), $e->getMessage());
            return false;
        }
        return $result;
    }

    function getAdminEmail() {
        global $adminEmail;

        return $adminEmail;
    }