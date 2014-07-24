<?php
    function get_contests_numbers() {

        $con = makeConnection();
        $query = "SELECT DISTINCT(contest_num)
                  FROM winners_en;";

        $query_res = prepareAndExecuteQuery($con,$query);
        $res = array();
        $c = 0;

        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($query_res));
        foreach($it as $v) {
            if($c++ % 2 == 0)
                array_push($res,$v);
        }
        return $res;
    }

    function removePhoto($photoPath) {
        $splitPath = explode("/", $photoPath);
        end($splitPath);
        $contest_num = prev($splitPath);

        $result = false;

        $con = makeConnection();
        $query = "UPDATE winners_en
                  SET number_of_pics = number_of_pics - 1
                  WHERE contest_num=:contest_num";

        try {
        $statement = $con->prepare($query);
        $statement->bindParam(':contest_num' ,$contest_num  ,PDO::PARAM_INT);
        $statement->execute();

        $file = glob($photoPath);
        if($file != null)
            $result = unlink($file[0]);
        return $contest_num;

        } catch (PDOException $e) {
            return false;
        }
    }
