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
</head>

<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">
            <h2>Subscribe</h2>

            <?php
                $showForm = true;

                if(isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    $mailCheck = spamCheck($email);
                    if ($mailCheck == false) {
                        echo "<p class='text form_error'>&emsp;Invalid email</p>";

                    } else {
                        $showForm = false;

                        $con = makeConnection();

                        $firstName = $_REQUEST['first_name'];
                        $lastName = $_REQUEST['last_name'];
                        isset($_REQUEST['bulletin'])?
                            $bulletin = true : $bulletin = false;

                        isset($_REQUEST['newsletter'])?
                            $newsletter = true : $newsletter = false;

                        $subscribed = "";
                        $bulletin? $subscribed .= "Bulletin, &emsp;" : "";
                        $newsletter? $subscribed .= "Newsletter" : $subscribed = substr($subscribed,0,8);

                        $sql = "INSERT INTO subscription(first_name,last_name,email,bulletin,newsletter)
                                    VALUES (:first_name, :last_name, :email, :bulletin, :newsletter)";
                        try {
                            $statement = $con->prepare($sql);

                            $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
                            $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
                            $statement->bindParam(':email', $email, PDO::PARAM_STR);
                            $statement->bindParam(':bulletin', $bulletin, PDO::PARAM_BOOL);
                            $statement->bindParam(':newsletter', $newsletter, PDO::PARAM_BOOL);
                            $statement->execute();

                            $content = '<html><body>'.
                                    '<div style="text-align: center; font-size: 300%; font-weight: 900; color: rgba(65,110,225,0.9);">
                                        Welcome To Costa-Rica Israel Friendship Association </div> <br> <hr>
                                        <div style="text-align: center; font-size: 200%; font-weight: 550; color: #348017;">
                                             You have been subscribed successfully!</div>
                                             <div>
                                    <table width=80% align="center" style="border-style:solid; border-width:medium; border-color:#E8E8E8;"> <tr> <td>
                                        <div style="text-align: left; font-size: 100%; font-weight: 225;">
                                            <p><b><u>Summary</u></b></p></div>
                                        <ul>
                                    <li><p><b>First name:</b> '.$firstName.'</p></li>'.
                                    '<li><p><b>Last name:</b> '.$lastName.'</p></li>'.
                                    '<li><p><b>E-Mail:</b> '.$email.'</p></li>'.
                                    '<li><p><b>Subscribed for:</b>&emsp;'.$subscribed.'</p></li>'.
                                    '</ul>'.
                                    '</td></tr></table></div></body></html>';

                            $subject = "Welcome To Costa-Rica Israel Friendship Association";
                            mail($email, $subject, $content, "From: $adminEmail\r\nContent-Type: text/html; charset=ISO-8859-1\r\n" );
                            
                            echo '<p class="form_granted">&emsp;Subscribed Successfully 
                                <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>
                                </p>';

                            $showForm = true;

                        } catch (PDOException $e) {
                            if ($e->errorInfo[1] == 1062) {
                                echo "<p class='text form_error'>&emsp;The e-mail: $email is already subscribed</p>";
                            } else {
                                echo 'could not subscribe... please contact admin!';
                                var_dump($e->getMessage());
                            }

                            $showForm = true;
                        }

                    }
                }

                if($showForm) {
            ?>
                <form class="general_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                    <fieldset>
                        <legend>Personal data:</legend>

                        <label for="first_name">First name</label>
                        <input name="first_name" class="form_field form_field_short" type="text" id="first_name" autofocus="" required><br>

                        <label for="last_name">Last name</label>
                        <input name="last_name" class="form_field form_field_short" type="text" id="last_name" required><br>

                        <label for="email">Email</label>
                        <input name="email" class="form_field form_field_short" type="email" id="email" required><br>

                        <label for="bulletin">Bulletin</label>
                        <input name="bulletin" type="checkbox" id="bulletin"><br>

                        <label for="newsletter">Newsletter</label>
                        <input name="newsletter" type="checkbox" id="newsletter"><br>

                    </fieldset>
                    <div id="formbuttons">
                        <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Submit</button>
                        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
                    </div>

                </form>

            <?php
                    echo '<script> 
                    $(".general_form").submit(function(){
                        if(!$(".general_form input:checked").length) {
                            alert("Please check at least one checkbox");
                            return false; } }); 
                        </script>';
                }
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
