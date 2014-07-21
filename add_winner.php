<?php
    include_once 'utils/control_panel_functions.php';
    securedSessionStart();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">

   <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <?php require 'utils/files.php' ?>
</head>

<body>
    <?php require 'templates/navbarpannel.php'?>

    <div id="container_center">
        <div class="container">

            <h2>Add Know Costa-Rica Contest Winners</h2>

            <?php

                if(!loggedIn()) {

                    header('Location: login.php');

                } else {

                    $pictures_exist = false;

                    if(isset($_REQUEST["email"])) {

                        if(!isset($_FILES["profile_pic"]["tmp_name"])) {
                            echo "<p class='text form_error'>&emsp;"."
                                Error: Please check your input for duplicated data . </p>";
                            goto form;
                        }

                        if (!check_file($_FILES["profile_pic"]["name"]))
                            goto form;

                        if ($_FILES['pictures']['error'] != UPLOAD_ERR_NO_FILE) {
                            $pictures_exist = true;
                            $uploaded_pictures = check_multiple_files('pictures');
                        }
                        
                        $contest_num    = htmlspecialchars(((int)$_REQUEST['year']-2005));
                        $email          = htmlspecialchars($_REQUEST['email']);
                        $institute_name = htmlspecialchars($_REQUEST['institute']);
                        $name           = htmlspecialchars($_REQUEST['full_name']);
                        $place          = (int)htmlspecialchars($_REQUEST['place']);
                        $subject        = htmlspecialchars($_REQUEST['subject']);
                        $tel_number     = htmlspecialchars($_REQUEST['mobile']);

                        if (spamCheck($email) == false) {
                            echo "<p class='text form_error'>&emsp;Invalid email</p>";
                          goto form;
                        }
                            
                        $con = makeConnection();
                        $num_of_pictures_in_db = 0;

                        /*$extension= end(explode(".", $_FILES["profile_pic"]["name"]));*/
                        $pic_name = (($place == "1") ? "first." : "second.") . 'jpg';
                        $pic_path   = "/Library/WebServer/Documents/costaRicaIsrael/img/winners/";

                        $sql = "SELECT COUNT(*) as num_of_rows FROM winners_en 
                                WHERE contest_num=:contest_num AND place=:place";
                        try {

                            $statement = $con->prepare($sql);

                            $statement->bindParam(':contest_num' ,$contest_num  ,PDO::PARAM_INT);
                            $statement->bindParam(':place'       ,$place        ,PDO::PARAM_INT);
                            $statement->execute();
                            $result = $statement->fetchAll();

                            if (sizeof($result) > 0 && $result[0]["num_of_rows"] > 0) {
                                echo "<p class='text form_error'>&emsp;"."
                                Error: Another winner is already subscribed as <b> ".($place == 1 ? "1st" : "2nd"). ' </b>place, please use EDIT mode .</p>';
                                goto form;
                            }
                            $statement->closeCursor();
                            
                            // folder creation
                            if (!is_dir($pic_path.$contest_num)) {
                                mkdir($pic_path.$contest_num, 0777, true);
                            }
                            //Uploading profile picture
                            try {
                                $pic_full_path =  $pic_path.$contest_num.'/'.$pic_name;
                                if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$pic_full_path)) {
                                    throw new Exception('Could not move file');
                                }
                                //Uploading pictures
                                if($pictures_exist) {
                                    $msg = "";
                                    for($i = 1, $count = 0 ; $i <= $uploaded_pictures["num_of_pictures"] ; $i++) {

                                        $pic_full_path =  $pic_path.$contest_num;
                                        $tmp_path = $uploaded_pictures["pictures_tmp"][($i-1)];
                                        $type     = $uploaded_pictures["types"][($i-1)];
                                        $filename = $uploaded_pictures["pictures_name"][($i-1)];

                                        if (!move_uploaded_file($tmp_path,$pic_full_path.'/'.($count+1).'.jpg')) {
                                            $msg .= '&#149 '. $filename .' <br>';
                                        } else {
                                            $count++;
                                        }
                                    } 
                                }
                            } catch (Exception $e) {
                                echo "<p class='text form_error'>&emsp;
                                Error moving profile pic file.. please try again</p>";
                                if(num_of_files_in_dir($pic_path.$contest_num) > 0)
                                    rmdir($pic_path.$contest_num);
                                goto form;
                            }

                        $sql = "INSERT INTO winners_en (contest_num,email,institute,name,number_of_pics,pic_path,place,subject,tel_number)
                                        VALUES (:contest_num, :email, :institute, :name, :number_of_pics, :pic_path, :place, :subject ,:tel_number);";
                            try {
                                $statement = $con->prepare($sql);

                                $statement->bindParam(':contest_num' ,$contest_num  ,PDO::PARAM_INT);
                                $statement->bindParam(':email'       ,$email        ,PDO::PARAM_STR);
                                $statement->bindParam(':institute'   ,$institute_name ,PDO::PARAM_STR);
                                $statement->bindParam(':name'        ,$name         ,PDO::PARAM_STR);
                                $statement->bindParam(':number_of_pics',$uploaded_pictures["num_of_pictures"] ,PDO::PARAM_INT);
                                $statement->bindParam(':pic_path'    ,$pic_name     ,PDO::PARAM_STR);
                                $statement->bindParam(':place'       ,$place        ,PDO::PARAM_INT);
                                $statement->bindParam('subject'      ,$subject      ,PDO::PARAM_STR);
                                $statement->bindParam(':tel_number'  ,$tel_number   ,PDO::PARAM_INT);
                                $statement->execute();
                                $statement->closeCursor();

                            } catch (PDOException $e) {
                                if ($e->errorInfo[1] == 1062) {
                                    echo "<p class='text form_error'>&emsp;
                                    Error: duplicate EMAIL in databse, please check email address.</p>";
                                } else {
                                    echo "<p class='text form_error'>&emsp; 
                                    Failed updating database..please try again.";
                                }
                                    unlink($pic_path.$contest_num.'/'.$pic_name);
                                if(num_of_files_in_dir($pic_path.$contest_num) == 0)
                                    rmdir($pic_path.$contest_num);
                                goto form;
                            }

                                // updatig winners pictures number - in a case of an update
                                if ($pictures_exist) {
                                $sql_count = "UPDATE winners_en SET number_of_pics=:count WHERE contest_num=:contest_num";
                                $statement_count = $con->prepare($sql_count);
                                $statement_count->bindParam(':count', $count, PDO::PARAM_INT);
                                $statement_count->bindParam(':contest_num', $contest_num, PDO::PARAM_INT);
                                $statement_count->execute();
                                }

                            } catch (PDOException $e) {
                                var_dump($e->getMessage());
                                if ($e->errorInfo[1] == 1062) {
                                    echo "<p class='text form_error'>&emsp;
                                    The winner: " . $full_name . " is already subscribed, use EDIT to change winner's data.</p>";
                                } else {
                                    echo "<p class='text form_error'>&emsp; 
                                    Failed updating database..please try again.";
                                }
                                goto form;
                            }

                            echo '<p class="form_granted">&emsp;Memebers added successfully!
                                <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>'
                                .(($msg != "") ? '<br> The following files failed to be upload: <br>'.$msg : '').'
                                  </p>';
                        }
                    }
                    form:
                        include 'templates/add_winner_form.php';
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
