<?php
    include 'db_connection.php';
    include 'email.php';

    function getEvent($eventId, $eventType) {
        $con = makeConnection();

        $sql = "SELECT date, name, description ,text FROM ".$eventType." WHERE id=".$eventId;

        $result = prepareAndExecuteQuery($con, $sql);

        return array("date"=>$result[0]['date'], "name"=>$result[0]['name'],
                    "description"=>$result[0]['description'], "text"=>$result[0]['text']);
    }

    if(isset($_POST['id'])) {
        echo json_encode(getEvent($_REQUEST['id'],$_REQUEST['eventType'].'_en'));
    }