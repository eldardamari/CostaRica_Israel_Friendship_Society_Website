<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
    <?php require 'utils/files.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">

            <h2>Contact us</h2>

            <?php
                $showForm = true;

                if(isset($_REQUEST["email"])) {

                    if (!check_file($_FILES["profile_pic"]["name"]))
                        goto form;

                    $email = $_REQUEST['email'];
                    $mailCheck = spamCheck($email);
                    if ($mailCheck == false) {
                        echo "<p class='text form_error'>&emsp;Invalid email</p>";
                      goto form;
                    } 

                    $con = makeConnection();
                    
                    $title      = htmlspecialchars($_REQUEST['title']);
                    $about_me    = htmlspecialchars($_REQUEST['about_me']);

                    $full_name  = $_REQUEST['full_name'];
                    $mobile     = $_REQUEST['mobile'];
                    $position   = $_REQUEST['position'];
                    $pic_path   = "/Library/WebServer/Documents/costaRicaIsrael/img/members/";
                    $pic_name = str_shuffle("12345").'_'.$_FILES["profile_pic"]["name"];
                        
                    echo $pic_name;
                        $sql = "START TRANSACTION;
                                    INSERT INTO members(name,email,position,tel_number,pic_path)
                                        VALUES (:name, :email, :position, :tel_number, :pic_path);

                                    SELECT @ID:=id FROM members WHERE email=:email;

                                    INSERT INTO aboutme(id,title,aboutme_text)
                                        VALUES (@ID, :title, :about_me);
                                COMMIT;
                                ROLLBACK;";
                        try {
                            $statement = $con->prepare($sql);
                            
                            $statement->bindParam(':name', $full_name, PDO::PARAM_STR);
                            $statement->bindParam(':email', $email, PDO::PARAM_STR);
                            $statement->bindParam(':position', $position, PDO::PARAM_STR);
                            $statement->bindParam(':tel_number', $mobile, PDO::PARAM_INT);
                            $statement->bindParam(':pic_path', $pic_name, PDO::PARAM_STR);
                            $statement->bindParam(':title', $title, PDO::PARAM_STR);
                            $statement->bindParam(':about_me', $about_me, PDO::PARAM_STR);
                            $statement->execute();
                            $statement->closeCursor();

                        } catch (PDOException $e) {
                            var_dump($e->getMessage());
                            if ($e->errorInfo[1] == 1062) {
                                echo "<p class='text form_error'>&emsp;The e-mail: $email is already subscribed</p>";
                            } else {
                                echo "<p class='text form_error'>&emsp; #1 Failed updating database..please try again.";
                            }
                            goto form;
                        }
                                
                        $sql_verify = "SELECT email FROM members WHERE email=:email";
                        try {
                            $statement_verify = $con->prepare($sql_verify);
                            $statement_verify->bindParam(':email', $email, PDO::PARAM_STR);
                            $statement_verify->execute();
                            $result = $statement_verify->fetchAll();


                            if ($result[0]["email"] == $email) { // check if insert sucsseced
                                try {
                                    if (!move_uploaded_file($_FILES["profile_pic"]["tmp_name"],$pic_path.$pic_name)) {
                                        throw new Exception('Could not move file');
                                    }
                                } catch (Exception $e) {
                                    echo "<p class='text form_error'>&emsp;
                                    Error moving profile pic file.. please try again</p>";
                                    goto form;
                                }
                            } else {
                                echo "<p class='text form_error'>&emsp;Failed updating database..
                                    please check if email address is not used by other member.";
                                    goto form;
                            }
                        } catch (PDOException $e) {
                            var_dump($e->getMessage());
                            echo "<p class='text form_error'>&emsp;#3 Failed updating database..please try again.";
                            goto form;
                        }
                    echo '<p class="form_granted">&emsp;Memebers added successfully! 
                        <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>
                        </p>';
                    }
                if($showForm) {
                form:
            ?>
                <form enctype="multipart/form-data" class="general_form" action=<?php echo $_SERVER["PHP_SELF"]?> method="post">

                <fieldset><legend>Personal data:</legend>

                    <label for="fname">Member name</label>
                    <input class="form_field" type="text" id="name" name="full_name" autofocus="" 
                        required pattern="[a-z|A-Z| ]*" title="English Letters Only"><br><br>

                    <label for="email">Email</label>
                    <input class="form_field" type="email" id="email" name="email" required><br><br>
                    
                    <label for="position">Position</label>
                    <input class="form_field" type="text" id="position" name="position" 
                        required pattern="[a-z|A-Z| ]*" title="English Letters Only"><br><br>

                    <label for="mobile">Mobile number</label>
                    <input class="form_field" type="tel" id="mobile" name="mobile" 
                        required pattern="[05]{2}[0|2-9][0-9]{7}" title="Enter a vaild Israeli mobile number 05********"><br><br>

                    <label for="profile_pic">Profile picture</label>
                    <input type="file" name="profile_pic" required><br><br>


                <fieldset><legend>About member:</legend>

                    <label for="member_title">Member title</label>
                    <textarea name="title" class="form_field form_field_medium" style="resize: none;" 
                        rows="5" maxlength="100" required=""></textarea> <br>
                    
                    <label for="about_me">About me</label>
                    <textarea name="about_me" class="form_field form_field_medium" style="resize: none;" 
                        rows="20" maxlength="10000" required=""></textarea> <br>


                </fieldset>
                <div id="formbuttons">
                    <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Save</button>
                    <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
                </div>
            </form>


            <?php
                }
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
