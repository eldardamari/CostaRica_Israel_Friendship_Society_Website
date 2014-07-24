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
    <link rel="stylesheet" href="/costaRicaIsrael/css/browser.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/browser.js"></script>
    <script src="js/edit_winner.js"></script>
    <?php require 'utils/files.php' ?>
    <?php include 'utils/edit_winners_functions.php' ?>
</head>

<body>
    <?php require 'templates/navbarpannel.php'?>

    <div id="container_center">
        <div class="container">

            <h2>Edit Events</h2>

            <?php
                if(!loggedIn()) {
                    header('Location: login.php');
                } else {

                    /*echo '<pre>';
                    var_dump($_REQUEST);
                    echo '</pre>';*/


                    if(isset($_POST['delete'])) {

                        if($con_num = removePhoto($_POST['delete'])) {
                            if(!isset($POST['year_pic']))
                                $con_year = ($con_num + 2005);  /*var_dump($_REQUEST);*/

                            echo "<p class='form_granted'> Success, photo was removed</p>";
                        }
                        else
                            echo "<script>alert('Failure, could not delete photo');</script>";

                        /*header('refresh:1;url=edit_winners.php');*/
                    }
                    if(isset($_POST['add'])) {
                    }

            ?>



            <?php
                    $pictures_exist = false;
                    $profile_pic_exist = false;

                    if(isset($_REQUEST["email"])) {

                        /*if(!isset($_FILES["profile_pic"]["tmp_name"])) {
                            echo "<p class='text form_error'>&emsp;"."
                                Error: Please check your input for duplicated data . </p>";
                            goto form;
                        }*/

                        if ($_FILES['profile_pic']['error'] != UPLOAD_ERR_NO_FILE) {
                            if (!check_file($_FILES["profile_pic"]["name"]))
                                goto form;
                            $profile_pic_exist = true;
                        }

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

                        $pic_name = (($place == "1") ? "first" : "second") . getFileExtension($_FILES["profile_pic"]["name"]);
                        /*$pic_path   = "img/winners/";*/
                        $pic_path   = "/Library/WebServer/Documents/costaRicaIsrael/img/winners/";

                        // check for existance of previous winner
                        /*$sql = "SELECT COUNT(*) as num_of_rows FROM winners_en 
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
                            $statement->closeCursor();*/
                            
                            // folder creation
                        try {
                            if (!is_dir($pic_path.$contest_num)) {
                                mkdir($pic_path.$contest_num, 0777, true);
                            }
                            //Uploading profile picture
                            try {
                                if($profile_pic_exist) {
                                    foreach (glob($pic_path.$contest_num.'/first*.*') as $filename) {
                                        unlink($filename);
                                    }
                                    $pic_full_path =  $pic_path.$contest_num.'/'.$pic_name;
                                    if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$pic_full_path)) {
                                        throw new Exception('Could not move file');
                                    }
                                }
                                
                                //Uploading pictures
                                if($pictures_exist) {
                                    $msg = "";
                                    for($i = 1, $count = 0 ; $i <= $uploaded_pictures["num_of_pictures"] ; $i++) {

                                        $pics_full_path =  $pic_path.$contest_num;
                                        $tmp_path = $uploaded_pictures["pictures_tmp"][($i-1)];
                                        $type     = $uploaded_pictures["pictures_type"][($i-1)];
                                        $filename = $uploaded_pictures["pictures_name"][($i-1)];
                                        $pic_name = $uploaded_pictures["pictures_uniqid"][($i-1)];

                                        if (!move_uploaded_file($tmp_path,$pics_full_path.'/'.$pic_name)) {
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

                            $sql = "UPDATE winners_en 
                                    SET contest_num   =:contest_num,
                                        email         =:email,
                                        institute     =:institute,
                                        name          =:name,
                                        number_of_pics=:number_of_pics,
                                        pic_path      =:pic_path,
                                        place         =:place,
                                        subject       =:subject,
                                        tel_number    =:tel_number 
                                    WHERE email=:email;";
                            try {
                                $statement = $con->prepare($sql);

                                $statement->bindParam(':contest_num' ,$contest_num  ,PDO::PARAM_INT);
                                $statement->bindParam(':email'       ,$email        ,PDO::PARAM_STR);
                                $statement->bindParam(':institute'   ,$institute_name ,PDO::PARAM_STR);
                                $statement->bindParam(':name'        ,$name         ,PDO::PARAM_STR);
                                $statement->bindParam(':number_of_pics',$uploaded_pictures["num_of_pictures"] ,PDO::PARAM_INT);
                                $statement->bindParam(':pic_path'    ,$pic_name     ,PDO::PARAM_STR);
                                $statement->bindParam(':place'       ,$place        ,PDO::PARAM_INT);
                                $statement->bindParam(':subject'     ,$subject      ,PDO::PARAM_STR);
                                $statement->bindParam(':tel_number'  ,$tel_number   ,PDO::PARAM_INT);
                                $statement->execute();
                                $statement->closeCursor();

                            } catch (PDOException $e) {
                                if ($e->errorInfo[1] == 1062) {
                                    echo "<p class='text form_error'>&emsp;
                                    Error: duplicate EMAIL in databse, please check email address.</p>";
                                } else {
                                    var_dump($e);
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

                                    $sql_count = "SELECT number_of_pics FROM winners_en 
                                                  WHERE contest_num=:contest_num
                                                  ORDER BY number_of_pics DESC 
                                                  LIMIT 1;";
                                    $statement_count = $con->prepare($sql_count);
                                    $statement_count->bindParam(':contest_num', $contest_num, PDO::PARAM_INT);
                                    $statement_count->execute();
                                    $result = $statement_count->fetchAll();

                                    /*echo '<pre>';
                                    var_dump($result);
                                    echo '</pre>';*/

                                    if (sizeof($result) > 0) {
                                        $count += $result[0]["number_of_pics"];
                                    }
                                    $statement->closeCursor();

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

                            echo '<p class="form_granted">&emsp;Memebers updated successfully!
                                <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>'
                                .(($msg != "") ? '<br> The following files failed to be upload: <br>'.$msg : '').'
                                  </p>';
                        }
                    }
                    form:
                        include 'templates/edit_winner_form.php';

            ?>
                        <form class="general_form" id="deletePhoto" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" >
                            <input type="hidden" id="year_pic" name="year_pic">
                            <input type="hidden" id="place_pic" name="place_pic">
                            <button type="submit" class="btn_default" id="action" name="delete">
                                Remove <span class="btn_icon icon_delete"></span>
                            </button>
                        </form>


        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>


