<?php
    include_once 'control_panel_functions.php';
    securedSessionStart();

    function get_winners_form($contest_num, $place) {

        if(loggedIn()) {

            try {
            $con = makeConnection();
            $sql = "SELECT * FROM winners_en 
                    WHERE contest_num=:num AND place=:place;";

            $statement = $con->prepare($sql);
            $statement->bindParam(':num' ,$contest_num  ,PDO::PARAM_INT);
            $statement->bindParam(':place',$place ,PDO::PARAM_INT);
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

    $contest_num = isset($_POST['contest_num']) ? $_POST['contest_num'] : "";
    $place = isset($_POST['place']) ? $_POST['place'] : "";

    echo json_encode(get_winners_form($contest_num,$place));
