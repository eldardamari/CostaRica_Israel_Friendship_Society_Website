<?php

    function check_file($filename) {

        if (check_file_length($filename)) {
          echo "<p class='text form_error'>&emsp; Error: File name is too long, need to be less than 225 characters!</p>";
          return false;
        }
        if (!check_file_type_and_size($_FILES["profile_pic"]["name"],
                                    $_FILES["profile_pic"]["type"],
                                    $_FILES["profile_pic"]["size"])) {
          echo "<p class='text form_error'>&emsp; Error: File type is wrong!</p>";
          return false;
        }
      if ($_FILES["profile_pic"]["error"] > 0) {
          echo "<p class='text form_error'>&emsp;
            Error uploading file.. please try again</p>";
          return false;
      }
        $_FILES["profile_pic"]["name"] = set_legal_filename($_FILES["profile_pic"]["name"]);
        return true;
    }

    function check_file_type_and_size($filename,$filetype,$filesize)
    {
                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                    $temp = explode(".", $filename);
                    $extension = end($temp);

                    return ((($filetype == "image/gif")
                    || ($filetype == "image/jpeg")
                    || ($filetype == "image/jpg")
                    || ($filetype == "image/pjpeg")
                    || ($filetype == "image/x-png")
                    || ($filetype == "image/png"))
                    && ($filesize > 0 && $filesize < 500000) //500kb limit
                    && in_array($extension, $allowedExts));
    }

    function check_file_name ($filename)
    {
        return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ?
            true : false);
    }

    function set_legal_filename($filename)
    {
        $filename = strtolower($filename); // lowecase
        $filename = preg_replace("/[^a-z0-9_\s\.]/", "", $filename); //remove bad characters
        $filename = preg_replace("/[\s-]+/", " ", $filename); // remove multiple space or dash
        $filename = preg_replace("/[\s_]/", "_", $filename); // convert space to underscore
        return $filename;
    }

    function check_file_length ($filename)
    {
        return (bool) ((mb_strlen($filename,"UTF-8") > 225) ? true : false);
    }