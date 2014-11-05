<?php
    function getEventsName($eventType) {

        $con = makeConnection();
        $query = "SELECT id, name FROM ".$eventType;

        $result = prepareAndExecuteQuery($con,$query);
        return $result;
    }

    function removePhoto($eventType, $photoPath) {
        $result = false;

        $splitPath = explode("/", $photoPath);
        end($splitPath);
        $eventId = prev($splitPath);

        $con = makeConnection();
        $query = "UPDATE ".$eventType."_en SET number_of_pics = number_of_pics - 1 WHERE id = '". $eventId ."'";

        if(prepareAndUpdate($con,$query)) {
            $file = glob($photoPath);
            if($file != null)
                $result = unlink($file[0]);
        }

        return $result;
    }

    function addEventToDBAndGetBackID($eventType, $date, $eventName, $description, $text, $num_of_pictures) {
        $id = 0;
        $con = makeConnection();

        $sql = "INSERT INTO ".$eventType."_en (date,name,description,text,number_of_pics)
                                    VALUES (:date, :name, :description, :text, :number_of_pics)";

        try {
            $statement = $con->prepare($sql);
            $statement->bindParam(':date' ,$date);
            $statement->bindParam(':name' ,$eventName, PDO::PARAM_STR);
            $statement->bindParam(':description' ,$description, PDO::PARAM_STR);
            $statement->bindParam(':text' ,$text, PDO::PARAM_STR);
            $statement->bindParam(':number_of_pics' ,$num_of_pictures, PDO::PARAM_INT);
            $statement->execute();

            $id = $con->lastInsertId();

        } catch (PDOException $e) {
            sendErrorToAdmin("DB ERROR: ".$e->getCode(), $e->getMessage());
            echo "<p class='text form_error'>&emsp;
                                    Failed updating database..please try again.";
        }

        return $id;
    }

    //Uploading pictures
    function uploadPhotosToEvent($uploaded_pictures, $directoryPath, $num_of_pictures) {

        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $msg = "";
        $count = 0;
        for($i = 0 ; $i < $num_of_pictures ; $i++) {
            $tmp_path = $uploaded_pictures['pictures_tmp'][$i];
            $filename = $uploaded_pictures['pictures_name'][$i];
            $pictures_uniqid = $uploaded_pictures['pictures_uniqid'][$i];

            if (!move_uploaded_file($tmp_path,$directoryPath.'/'.$pictures_uniqid)) {
                $msg .= '&#149 '. $filename .' <br>';
            } else {
                $count++;
            }
        }

        echo ($msg != "") ? '<p class="text form_error">&emsp;
                             The following files failed to be upload:
                             <br>'.$msg.'</p>' : '';

        return $count;
    }

    function updateEvent($eventType, $id, $date, $name, $description, $text, $filesAdded) {
        $success = false;
        $con = makeConnection();

        try {
            $sql = "UPDATE ".$eventType."_en
                    SET name=:name, date=:date, description=:description,
                    text=:text, number_of_pics= number_of_pics + :filesAdded
                    WHERE id=:id";

            $statement = $con->prepare($sql);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':date', $date);
            $statement->bindParam(':description', $description);
            $statement->bindParam(':text', $text);
            $statement->bindParam(':filesAdded', $filesAdded);
            $statement->bindParam(':id', $id);
            $success = $statement->execute();

        } catch (PDOException $e) {
            sendErrorToAdmin("DB ERROR - Updating event id: $id", $e->getMessage());
            echo "<p class='text form_error'>&emsp;
                                    Failed updating database..please try again.";
        }

        return $success;
    }

    function updateNumOfPics($eventType, $filesMoved) {

        $con = makeConnection();
        try {
            $sql_count = "UPDATE ".$eventType."_en SET number_of_pics=:count WHERE id=:id";
            $statement_count = $con->prepare($sql_count);
            $statement_count->bindParam(':count', $count, PDO::PARAM_INT);
            $statement_count->bindParam(':id', $id, PDO::PARAM_INT);
            $statement_count->execute();
        } catch (PDOException $e) {
            sendErrorToAdmin("DB ERROR - Updating event id: $id num_of_pics to $filesMoved",
                $e->getMessage());
            echo "<p class='text form_error'>&emsp;
                                    Failed updating database..please try again.";
        }
    }

    function removeEvent($eventType, $eventId, $directoryPath) {

        $con = makeConnection();

        $sql = "DELETE FROM ".$eventType."_en
                WHERE id =".$eventId;
        $success = prepareAndUpdate($con, $sql);

        if($success) {
            $files = glob($directoryPath.$eventId."/*");

            foreach($files as $file) {
                unlink($file);
            }

            if (is_dir($directoryPath.$eventId))
                rmdir($directoryPath.$eventId);

            return true;

        } else {
            return false;
        }
    }

    date_default_timezone_set('Israel'); // important for date format

    if(isset($_POST['deleteEvent'])) {
        if(removeEvent(strtolower($eventType).'s',$_POST['deleteEvent'],$directoryPath)){
            echo '<p class="form_granted">&emsp;Event was removed successfully!
                                        <img src="./img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';
        } else {
            echo "<p class='text form_error'>&emsp;
                                        could not remove event ".$eventId.", please try again";
        }

//        header('refresh:2;url='.$_SERVER['PHP_SELF'].'?0');
    }

    if(isset($_POST['deletePhoto'])) {

        if(removePhoto(strtolower($eventType).'s', $_POST['deletePhoto']))
            echo '<p class="form_granted">&emsp;photo was removed successfully!
                                        <img src="./img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';

        else
            echo "<p class='text form_error'>&emsp; could not delete photo";

//        header('refresh:2;url='.$_SERVER['PHP_SELF'].'?0');
    }

    if(isset($_POST['updateEvent'])) {
        $id = $_POST['eventId'];

        $filesMoved = 0;
        if ($_FILES['pictures']['error'] != UPLOAD_ERR_NO_FILE) {
            $uploaded_pictures = check_multiple_files('pictures');
            $num_of_pictures = $uploaded_pictures['num_of_pictures'];
            $filesMoved = uploadPhotosToEvent($uploaded_pictures, $directoryPath.$id, $num_of_pictures);
        }

        $date = $_POST['date'];

        $eventName = htmlspecialchars(ucfirst($_POST['eventName']));

        $description = htmlspecialchars($_POST['description']);
        $description = filter_var($description,FILTER_SANITIZE_STRING);

        $text = htmlspecialchars($_POST['text']);
        $text = filter_var($text,FILTER_SANITIZE_STRING);
//
        if( updateEvent(strtolower($eventType).'s', $id, $date, $eventName, $description, $text, $filesMoved) )
            echo '<p class="form_granted">&emsp;Event was updated successfully!
                                        <img src="./img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';

        else
            echo "<p class='text form_error'>&emsp; could not update event";

//        header('refresh:2;url='.$_SERVER['PHP_SELF'].'?0');
    }
    if(isset($_POST['add'])) {

        if ($_FILES['pictures']['error'] != UPLOAD_ERR_NO_FILE) {
            $uploaded_pictures = check_multiple_files('pictures');
        }

        $num_of_pictures = $uploaded_pictures['num_of_pictures'];

        $date = $_POST['date'];

        $eventName = htmlspecialchars($_POST['eventName']);

        $description = htmlspecialchars($_POST['description']);
        $description = filter_var($description,FILTER_SANITIZE_STRING);

        $text = htmlspecialchars($_POST['text']);
        $text = filter_var($text,FILTER_SANITIZE_STRING);

        $id = addEventToDBAndGetBackID(strtolower($eventType).'s', $date, $eventName, $description, $text, $num_of_pictures);

        $filesMoved = 0;
        if($id) {
            $filesMoved = uploadPhotosToEvent($uploaded_pictures, $directoryPath.$id, $num_of_pictures);

            // in case of update
            if($filesMoved != $num_of_pictures)
                updateNumOfPics(strtolower($eventType).'s', $filesMoved);

            echo '<p class="form_granted">&emsp;Event added successfully!
                                        <img src="./img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';

//            header('refresh:2;url='.$_SERVER['PHP_SELF']);

        } else {
            echo "<p class='text form_error'>&emsp;
                                        Failed updating database..please try again.";
        }

    }
