<?php

define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

function check_file($filename) {
    if (check_file_length($filename)) {
      echo "<p class='text form_error'>&emsp; Error: File name is too long, need to be less than 225 characters!</p>";
      return false;
    }
    if (!check_file_type_and_size(  $_FILES["profile_pic"]["name"],
                                    $_FILES["profile_pic"]["type"],
                                    $_FILES["profile_pic"]["size"])) {
      echo "<p class='text form_error'>&emsp; Error: Profile picture type or size is unvaild (max file size: 5MB)!</p>";
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


function check_document($filename) {

    $allowedExts = array("doc", "docx", "pdf");
    $temp = explode(".", $_FILES[$filename]["name"]);
    $extension = end($temp);

    if ($_FILES[$filename]["error"] > 0) {
        echo "<p class='text form_error'>&emsp; Error: File can't be opened...please try again!</p>";
        return false;
    }
    if ( $_FILES[$filename]["type"] != "application/pdf" &&
        $_FILES[$filename]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
        $_FILES[$filename]["type"] != "application/msword") {    
            echo "<p class='text form_error'>&emsp; Error: File type is illigal (Only *.doc / *.docx / *.pdf)...please try again!</p>";
            return false;
        }
    if (!in_array($extension, $allowedExts)) {
        echo "<p class='text form_error'>&emsp; Error: File extension error (Only *.doc / *.docx / *.pdf)...please try again!</p>";
        return false;
    }
    if ($_FILES[$filename]["size"] > 2*MB) {
        echo "<p class='text form_error'>&emsp; Error: Document size is unvaild (max file size: 2MB)!</p>";
      return false;
    }
    return true;
}

function check_file_type_and_size($filename,$filetype,$filesize)
{
                $allowedExts = array("gif", "jpeg", "jpg", "png");
                $temp = explode(".", $filename);
                $extension = strtolower(end($temp));
                return ((($filetype == "image/gif")
                || ($filetype == "image/jpeg")
                || ($filetype == "image/jpg")
                || ($filetype == "image/pjpeg")
                || ($filetype == "image/x-png")
                || ($filetype == "image/png"))
                && ($filesize > 0 && $filesize < 50000000) //5000kb limit
                && in_array($extension, $allowedExts));
}

function check_file_name ($filename) {
    return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? 
        true : false);
}

function set_legal_filename($filename) {
    $filename = strtolower($filename); // lowecase
    $filename = preg_replace("/[^a-z0-9_\s\.]/", "", $filename); //remove bad characters
    $filename = preg_replace("/[\s-]+/", " ", $filename); // remove multiple space or dash
    $filename = preg_replace("/[\s_]/", "_", $filename); // convert space to underscore
    return $filename;
}

function check_file_length ($filename) {
    return (bool) ((mb_strlen($filename,"UTF-8") > 225) ? true : false);
}

function check_multiple_files($pictures_var) {

    $pictures = array("num_of_pictures" => 0, "pictures_tmp" => 0, 
                      "pictures_type" => 0, "pictures_name" => 0, "pictures_uniqid"=>0);
    $num_of_pictures = 0;
    $pictures_tmp   = array ();
    $pictures_type = array ();
    $pictures_name  = array ();
    $pictures_uniqid = array ();

    foreach($_FILES[$pictures_var]['tmp_name'] as $key => $tmp_name) {

        $file_name  =   $_FILES[$pictures_var]['name'][$key];
        $file_size  =   $_FILES[$pictures_var]['size'][$key];
        $file_tmp   =   $_FILES[$pictures_var]['tmp_name'][$key];
        $file_type  =   $_FILES[$pictures_var]['type'][$key];

        if (!check_file_type_and_size($file_name,$file_type,$file_size))
            continue;

        $num_of_pictures++;
        array_push($pictures_tmp,$file_tmp);
        array_push($pictures_type,get_type($file_type));
        array_push($pictures_name,$file_name);
        array_push($pictures_uniqid,uniqid(get_prefix()).getFileExtension($file_name));
    }

    $pictures['num_of_pictures'] = $num_of_pictures;
    $pictures['pictures_tmp'] = $pictures_tmp;
    $pictures['pictures_type'] = $pictures_type;
    $pictures['pictures_name'] = $pictures_name;
    $pictures['pictures_uniqid'] = $pictures_uniqid;
    return $pictures;
}

function num_of_files_in_dir($path) {
    $sum = 0;
    $dir = new DirectoryIterator($path);
    foreach($dir as $file ){
        if(!$file->isDot())
            $sum++;
    }
    return $sum;
}

function getFileExtension($filename) {
    $splitFilename = explode(".", $filename);
    $extension = end($splitFilename);

    return '.'.$extension;
}

function get_prefix() {
    if (substr_count($_SERVER['PHP_SELF'],'member')) 
        return 'member_';

    if (substr_count($_SERVER['PHP_SELF'],'winner'))
        return 'winner_';

    if (substr_count($_SERVER['PHP_SELF'],'event'))
        return 'event_';

    if (substr_count($_SERVER['PHP_SELF'],'meeting'))
        return 'meeting_';
}

function get_type($file_type) {
    if (($pos = strpos($file_type, "/")) !== FALSE) { 
        return substr($file_type, $pos+1); 
    } else {
        return "jpg";
    }
}
