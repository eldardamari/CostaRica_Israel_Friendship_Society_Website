<?php
    include_once 'control_panel_functions.php';
    securedSessionStart();

    function get_subscriptions_data($table,$row) {

        if(loggedIn()) {

            try {
            $con = makeConnection();
            $sql = "SELECT * FROM ". $table ." 
                ORDER BY year DESC , month DESC
                LIMIT ".$row." , 6;";

            $statement = $con->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            /*echo '<pre>';
            var_dump(sizeof($result));
            echo '</pre>';
            return $result;*/

            if(!sizeof($result))
                return 0;
    
        $res = array();
        $c = 0;

        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($result));
        foreach($it as $v) {
            if($c++ % 2 == 0)
                array_push($res,$v);
        }
        return $result;

    } catch (Exception $e) {
        return 0;
    }
        } else {
            header('Location: login.php');
        }
    }

    $table = isset($_POST['table']) ? $_POST['table'] : "";
    $row = isset($_POST['row']) ? $_POST['row'] : "";

    echo json_encode(get_subscriptions_data($table,$row));
