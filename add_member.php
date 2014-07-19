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
    <?php require 'utils/files.php' ?>
</head>

<body>
    <?php require 'templates/navbarpannel.php'?>

    <div id="container_center">
        <div class="container">

            <h2>Add Members</h2>

            <?php

                if(!loggedIn()) {

                    header('Location: login.php');

                } else {

                    if(isset($_REQUEST["email"])) {

                        if (!check_file($_FILES["profile_pic"]["name"]))
                            goto form;

                        $email = $_REQUEST['email'];

                        if (spamCheck($email) == false) {
                            echo "<p class='text form_error'>&emsp;Invalid email</p>";
                          goto form;
                        }

                        $con = makeConnection();

                        $title      = htmlspecialchars($_REQUEST['title']);
                        $about_me    = htmlspecialchars($_REQUEST['about_me']);

                        $full_name  = $_REQUEST['full_name'];
                        $mobile     = $_REQUEST['mobile'];
                        $position   = $_REQUEST['position'];
                        $pic_path   = "img/members/";
                        $pic_name = uniqid('member_');

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

                                // check if insert sucsseced
                                if ($result[0]["email"] == $email) {

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

                    form:
                        include 'templates/add_member_form.php';
                }
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
