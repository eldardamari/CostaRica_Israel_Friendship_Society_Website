<?php

    function makeConnection() {
        // Database info
        $hostname = 'localhost';
        $dbname   = 'costa_rica_israel';
        $db_username = 'root';
        $db_password = 'root';

        $con = new PDO("mysql:host=$hostname;dbname=$dbname",$db_username,$db_password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $con;
    }

    function prepareAndExecuteQuery($con, $sql) {
        try {
            $statement = $con->prepare($sql);
            $statement->execute();

            $result = $statement->fetchAll();

        } catch (PDOException $e) {
            sendErrorToAdmin("DB ERROR - ON QUERY: ". $sql, $e->getMessage());
            return false;
        }
        return $result;
    }

    function prepareAndUpdate($con, $sql) {
        $result = false;
        try {
            $statement = $con->prepare($sql);
            $result = $statement->execute();
        } catch (PDOException $e) {
            sendErrorToAdmin("DB ERROR - ON QUERY: ". $sql, $e->getMessage());
        }
        return $result;
    }
