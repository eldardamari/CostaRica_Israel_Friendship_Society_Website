<?php
    include 'db_connection.php';
    include 'email.php';

    function getEvent($eventId, $eventType) {
        $con = makeConnection();

        $sql = "SELECT date, name, description FROM ".$eventType." WHERE id=".$eventId;

        $result = prepareAndExecuteQuery($con, $sql);

        return array("date"=>$result[0]['date'], "name"=>$result[0]['name'], "description"=>$result[0]['description']);
    }

    if(isset($_REQUEST['id'])) {
        echo json_encode(getEvent($_REQUEST['id'],$_REQUEST['eventType'].'_en'));
    }