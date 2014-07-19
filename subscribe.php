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

                            sendWelcomeMail($email,$firstName,$lastName,$subscribed);

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

                    include 'templates/subscribe_form.php';

                    echo   '<script>
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
