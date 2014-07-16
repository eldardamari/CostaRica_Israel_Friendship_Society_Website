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

                            echo    '<p class="text"> You have been subscribed successfully!</p>'.
                                    '<p>Summary</p><ul>'.
                                    '<li><p>First name: '.$firstName.'</p></li>',
                                    '<li><p>Last name: '.$lastName.'</p></li>',
                                    '<li><p>E-Mail: '.$email.'</p></li>',
                                    '<li><p>Subscribed for:&emsp;'.$subscribed.'</p></li>',
                                    '</ul>';

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
                }
            ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
