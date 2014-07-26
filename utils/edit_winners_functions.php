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

function files_validation(&$pictures_exist) 
{
    if (($_FILES['pictures']['error'][0] != UPLOAD_ERR_NO_FILE)) {
        $pictures_exist = true;
        return check_multiple_files('pictures');
    }
}

function set_variables(&$contest_num, &$email, &$institute_name, &$name,
                       &$place, &$subject, &$tel_number) 
{ // need to sanitaize
    $contest_num    = htmlspecialchars(((int)$_REQUEST['year']-2005));
    $contest_num    = filter_var($contest_num,FILTER_SANITIZE_NUMBER_INT);

    $email          = htmlspecialchars($_REQUEST['email']);
    $email          = filter_var($email,FILTER_SANITIZE_EMAIL);
    
    $institute_name = htmlspecialchars($_REQUEST['institute']);
    $institute_name = filter_var($institute_name,FILTER_SANITIZE_STRING);

    $name           = htmlspecialchars($_REQUEST['full_name']);
    $name           = filter_var($name,FILTER_SANITIZE_STRING);

    $place          = (int)htmlspecialchars($_REQUEST['place']);
    $place          = filter_var($place,FILTER_SANITIZE_NUMBER_INT);

    $subject        = htmlspecialchars($_REQUEST['subject']);
    $subject        = filter_var($subject,FILTER_SANITIZE_STRING);

    $tel_number     = htmlspecialchars($_REQUEST['mobile']);
    $tel_number     = filter_var($tel_number,FILTER_SANITIZE_NUMBER_INT);
}

function folder_creation(&$pic_path, &$contest_num) 
{
    if (!is_dir($pic_path.$contest_num))
        mkdir($pic_path.$contest_num, 0777, true);
}

function uploading_profile_pic( &$profile_pic_exist, &$place, &$pic_path, 
                                &$contest_num, &$pic_name, &$pic_full_path)
{
    if($profile_pic_exist) {
        $place_prefix = (($place == "1") ? "first" : "second");
        foreach (glob($pic_path.$contest_num.'/'.$place_prefix.'*.*') as $filename) {
            unlink($filename);
        }
        $pic_full_path =  $pic_path.$contest_num.'/'.$pic_name;
        if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$pic_full_path)) {
            throw new Exception('Could not move file');
        }
    }
}
function uploading_pictures(&$pictures_exist, &$count, &$uploaded_pictures,
                            &$pic_path, &$contest_num, &$err_msg)
{
    if($pictures_exist) {
        $err_msg = "";
        for($i = 1, $count = 0 ; $i <= $uploaded_pictures["num_of_pictures"] ; $i++) {

            $pics_full_path =  $pic_path.$contest_num;
            $tmp_path = $uploaded_pictures["pictures_tmp"][($i-1)];
            $type     = $uploaded_pictures["pictures_type"][($i-1)];
            $filename = $uploaded_pictures["pictures_name"][($i-1)];
            $pic_name = $uploaded_pictures["pictures_uniqid"][($i-1)];

            if (!move_uploaded_file($tmp_path,$pics_full_path.'/'.$pic_name)) {
                $err_msg .= '&#149 '. $filename .' <br>';
            } else {
                $count++;
            }
        }
    }
}

function add_check_duplicated(&$con, &$contest_num, &$place)
{
    $sql = "SELECT COUNT(*) as num_of_rows FROM winners_en 
        WHERE contest_num=:contest_num AND place=:place";

        $statement = $con->prepare($sql);

        $statement->bindParam(':contest_num' ,$contest_num  ,PDO::PARAM_INT);
        $statement->bindParam(':place'       ,$place        ,PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();

        if (sizeof($result) > 0 && $result[0]["num_of_rows"] > 0) {
            echo "<p class='text form_error'>&emsp;"."
                Error: Another winner is already subscribed as <b> ".($place == 1 ? "1st" : "2nd"). ' </b>place, please use EDIT mode .</p>';
            /*goto form;*/
            return false;
        }
        $statement->closeCursor();
        return true;
}

function execute_query(&$con, &$sql, &$contest_num, &$email, &$institute_name, &$name, 
                       &$uploaded_pictures, &$pic_name, &$place, &$subject, &$tel_number,
                       $pictures_exist, $profile_pic_exist)
{
    $statement = $con->prepare($sql);

    $statement->bindParam(':contest_num' ,$contest_num  ,PDO::PARAM_INT);
    $statement->bindParam(':email'       ,$email        ,PDO::PARAM_STR);
    $statement->bindParam(':institute'   ,$institute_name ,PDO::PARAM_STR);
    $statement->bindParam(':name'        ,$name         ,PDO::PARAM_STR);
    if($pictures_exist)
        $statement->bindParam(':number_of_pics',$uploaded_pictures["num_of_pictures"] ,PDO::PARAM_INT);
    if($profile_pic_exist)
        $statement->bindParam(':pic_path'    ,$pic_name     ,PDO::PARAM_STR);
    $statement->bindParam(':place'       ,$place        ,PDO::PARAM_INT);
    $statement->bindParam(':subject'     ,$subject      ,PDO::PARAM_STR);
    $statement->bindParam(':tel_number'  ,$tel_number   ,PDO::PARAM_STR);
    $statement->execute();
    $statement->closeCursor();
}

function check_exist_email_before_update(&$con, $email, $name, $tel_number)
{
    $sql = "SELECT * FROM winners_en WHERE email=:email";

    $statement = $con->prepare($sql);
    $statement->bindParam(':email' ,$email ,PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();

    if (sizeof($result) > 0 && $result[0]['name'] != $name 
        && $result[0]['tel_number'] != $tel_number)
        return true;
    return false;
}

$add_mode   = (isset($_REQUEST['add_winner_request'])   ? true : false);
$edit_mode  = (isset($_REQUEST['edit_winner_request']) 
            || isset($_REQUEST['edit_winner_request'])  ? true : false);

$pictures_exist     = false;
$profile_pic_exist  = false;

$contest_num = $email = $institute_name = $name = $place = $subject = "";
$tel_number = $err_msg = $pic_full_path = "";



    if(isset($_POST['deletePhoto'])) {

        if($con_num = removePhoto($_POST['deletePhoto'])) {
            if(!isset($POST['year_pic']))
                $con_year = ($con_num + 2005);
                $edit_mode = true;
            echo "<p class='form_granted'> Success, photo was removed</p>";
            goto form;
            
        }
        else
            echo "<script>alert('Failure, could not delete photo');</script>";
    }

    if($add_mode || $edit_mode) {

        if ($_FILES['profile_pic']['error'] != UPLOAD_ERR_NO_FILE) {
            if (!check_file($_FILES["profile_pic"]["name"]))
                goto form;
            $profile_pic_exist = true;
        }


        $uploaded_pictures = files_validation($pictures_exist);

        set_variables($contest_num, $email, $institute_name, $name,
                               $place, $subject, $tel_number);

        if (spamCheck($email) == false) {
            echo "<p class='text form_error'>&emsp;Invalid email</p>";
            goto form;
        }

        $con = makeConnection();
        $num_of_pictures_in_db = 0;

        $pic_name = (($place == "1") ? "first" : "second") . getFileExtension($_FILES["profile_pic"]["name"]);
        /*$pic_path   = "img/winners/";*/
        $pic_path   = "/Library/WebServer/Documents/costaRicaIsrael/img/winners/";

        try {
        if($add_mode) {
            if(!add_check_duplicated($con, $contest_num, $place))
                goto form;
        }
            
        folder_creation($pic_path, $contest_num);

        try {
            uploading_profile_pic( $profile_pic_exist, $place, $pic_path, $contest_num, $pic_name, $pic_full_path);
            uploading_pictures($pictures_exist, $count, $uploaded_pictures, $pic_path, $contest_num, $err_msg);

        } catch (Exception $e) {
            echo "<p class='text form_error'>&emsp;
            Error moving profile pic file.. please try again</p>";
            if(num_of_files_in_dir($pic_path.$contest_num) > 0)
                rmdir($pic_path.$contest_num);
            goto form;
        }

        $sql = ($add_mode == true ?
            "INSERT INTO 
                winners_en (contest_num,email,institute,name,number_of_pics,pic_path,
                        place,subject,tel_number)
             VALUES (:contest_num, :email, :institute, :name, :number_of_pics, :pic_path, 
                     :place, :subject ,:tel_number);" 
             :
            "UPDATE winners_en 
                SET contest_num   =:contest_num,
                    email         =:email,
                    institute     =:institute,
                    name          =:name,".
                    ($pictures_exist ? 'number_of_pics = number_of_pics + :number_of_pics, ' : ' ').
                    ($profile_pic_exist ? 'pic_path     =:pic_path, ' : ' ')."
                    place         =:place,
                    subject       =:subject,
                    tel_number    =:tel_number 
                    WHERE email=:email;");
        try {

        if($edit_mode) 
            if(check_exist_email_before_update($con, $email, $name, $tel_number)) {
                echo "<p class='text form_error'>&emsp;
                Error: duplicate EMAIL in databse, please check email address.</p>";
                goto form;
            }


         execute_query($con, $sql, $contest_num, $email, $institute_name, $name, 
                               $uploaded_pictures, $pic_name, $place, $subject, $tel_number,
                               $pictures_exist, $profile_pic_exist);

        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "<p class='text form_error'>&emsp;
                Error: duplicate EMAIL in databse, please check email address.</p>";
            } else {
                echo "<p class='text form_error'>&emsp; 
                Failed updating database..please try again.";
            }

            // Remove profile picture
            unlink($pic_full_path);
            // Remove pictures
            foreach($uploaded_pictures["pictures_uniqid"] as $file) {
                unlink($pic_path.$contest_num.'/'.$file);
            }
            if (num_of_files_in_dir($pic_path.$contest_num) == 0)
                rmdir($pic_path.$contest_num);
            goto form;
        }

        // updatig winners pictures number - in a case of an update
        if ($pictures_exist) {

            $sql_count = ($add_mode == true ?
                "SELECT number_of_pics FROM winners_en 
                    WHERE contest_num=:contest_num AND email != :email;"
                :
                "SELECT * FROM winners_en 
                      WHERE contest_num=:contest_num 
                      ORDER BY number_of_pics DESC 
                      LIMIT 1;");

            $statement_count = $con->prepare($sql_count);
            $statement_count->bindParam(':contest_num', $contest_num, PDO::PARAM_INT);
            if($add_mode) $statement_count->bindParam(':email', $email, PDO::PARAM_STR);
            $statement_count->execute();
            $result = $statement_count->fetchAll();


            if (sizeof($result) > 0) {
                $count += $result[0]["number_of_pics"];
            }
            $statement_count->closeCursor();

            $sql_count = "UPDATE winners_en SET number_of_pics=:count WHERE contest_num=:contest_num";
            $statement_count = $con->prepare($sql_count);
            $statement_count->bindParam(':count', $count, PDO::PARAM_INT);
            $statement_count->bindParam(':contest_num', $contest_num, PDO::PARAM_INT);
            $statement_count->execute();

        }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                echo "<p class='text form_error'>&emsp;
                The winner: " . $full_name . " is already subscribed, use EDIT to change winner's data.</p>";
            } else {
                echo "<p class='text form_error'>&emsp; 
                Failed updating database..please try again.";
            }
            goto form;
        }

        echo '<p class="form_granted">&emsp;Memeber '.($add_mode ? 'added' : 'edited').' successfully!
            <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>'
            .(($err_msg != "") ? '<br> The following files failed to be upload: <br>'.$err_msg : '').'
              </p>';
        }
    form:

