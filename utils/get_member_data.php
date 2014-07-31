<?php
    include_once 'control_panel_functions.php';
    securedSessionStart();

    function get_member_data($userId) {

        if(loggedIn()) {

            try {
            $con = makeConnection();
            $sql = "SELECT *
                    FROM aboutme NATURAL JOIN members
                    WHERE id=:id";

            $statement = $con->prepare($sql);
            $statement->bindParam(':id' ,$userId  ,PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll();

            if(!sizeof($result))
                return 0;
    
        $res = array();
        $c = 0;

        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($result));
        foreach($it as $v) {
            if($c++ % 2 == 0)
                array_push($res,$v);
        }
        return $result[0];

    } catch (Exception $e) {
        return 0;
    }
        } else {
            header('Location: login.php');
        }
    }

    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : "";

    echo json_encode(get_member_data($userId));
