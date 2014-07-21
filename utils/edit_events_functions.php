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