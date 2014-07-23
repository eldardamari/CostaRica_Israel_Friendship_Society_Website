<?php
    function removePhoto($photoPath) {
        $result = false;

        $splitPath = explode("/", $photoPath);
        end($splitPath);
        $eventId = prev($splitPath);

        $con = makeConnection();
        $query = "UPDATE events_en
                  SET number_of_pics = number_of_pics - 1
                  WHERE id = '". $eventId ."'";

        if(prepareAndUpdate($con,$query)) {
            $file = glob($photoPath);
            if($file != null)
                $result = unlink($file[0]);
        }

        return $result;
    }

    function addEventToDBAndGetBackID($date, $eventName, $description, $text, $num_of_pictures) {
        $id = 0;
        $con = makeConnection();

        $sql = "INSERT INTO events_en (date,name,description,text,number_of_pics)
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
        } else {
            echo "<p class='text form_error'>&emsp;
                    event's directory already exist.";
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

    function updateNumOfPics($filesMoved) {

        $con = makeConnection();
        try {
            $sql_count = "UPDATE events_en SET number_of_pics=:count WHERE id=:id";
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