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

            <h2>Contact us</h2>

            <?php
                $showForm = true;

                $con = makeConnection();
                $sql = "SELECT * FROM members";

                if(!$result = prepareAndExecuteQuery($con,$sql))
                    echo 'error reading from database... please contact admin!';

                if(isset($_REQUEST['email'])) {
                    $email = $_REQUEST['email'];
                    $mailCheck = spamCheck($email);
                    if ($mailCheck == false) {
                        echo "<p class='text form_error'>&emsp;Invalid email</p>";
                    } else {
                        $showForm = false;

                        $subject = htmlspecialchars($_REQUEST['subject']);
                        $content = htmlspecialchars($_REQUEST['content']);

                        $content = wordwrap($content, 70, "\n");

                        // on server there will be a ma
                        $sql = "SELECT email FROM members WHERE id=:id";
                        try {
                            $statement = $con->prepare($sql);
                            $statement->bindParam(':id',$_REQUEST['contact']);
                            $statement->execute();

                            $contact = $statement->fetch();

                        } catch (PDOException $e) {
                            var_dump($e->getMessage());
                            return false;
                        }

                        $sent = mail($contact['email'], $subject, $content, "From: $email\n");

                        echo "<p class='text'>Thank you for sending us an email,"
                            ."<br>We will contact you as soon as possible.</p>";
                    }
                }

                if($showForm) {
            ?>

            <form class="general_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                <fieldset>
                    <label for="from">From</label>
                    <input name="email" type="email" id="from" class="form_field form_field_short" placeholder="Insert Your Email" required="">
                    <br><br>

                    <label for="contact">To</label>
                    <select name="contact" id="contact" class="form_field form_field_short" required="">
                        <option value="" disabled>Select Contact</option>
                        <?php
                            foreach($result as $member) {
                                echo '<option value="'.$member['id'].'" >'.$member['name'].'</option>"';
                            }
                        ?>
                    </select>
                    <br><br>

                    <label for="subject">Subject</label>
                    <input name="subject" type="text" id="subject" class="form_field form_field_medium" placeholder="Enter Subject" required="">
                    <br><br>

                    <label for="mailContent">Content</label>
                    <textarea name="content" id="mailContent" class="form_field form_field_medium" style="resize: none;" rows="15" maxlength="300" required=""></textarea>
                </fieldset>

                <div id="formbuttons">
                    <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Send</button>
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