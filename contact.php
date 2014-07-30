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

            <h2 class="text_center">Contact us</h2>

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
                        $content = '<br/>'.str_replace("\n","<br/>",$content);

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

                        sendMailToMember($contact['email'], $subject, $content, $email);

                        echo "<p class='text text_center'>Thank you for sending us an e-mail,"
                            ."<br>We will contact you as soon as possible.</p>"
                            ."<p class='text text_center'> You are now being redirected to Home...</p>";

                        header( "refresh:5;url=./" );
                    }
                }

                if($showForm) {
                    include 'templates/contact_form.php';
                }
            ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
