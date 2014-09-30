<?php
    include_once 'utils/control_panel_functions.php';
    securedSessionStart();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Control panel</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/form.css">

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/login.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

</head>
<body>
    <?php include_once("analyticstracking.php") ?>
    <?php include 'templates/navbarpannel.php' ?>

    <div id="container_center">
        <div class="container text">
            <h2>Control Panel</h2>

            <?php

                if(!loggedIn()) {

                    header('Location: login.php');

                } else {

                    if(isset($_GET['addmember'])) {
                        echo '<br><img src="img/profile.jpg">';
                    }
                    elseif(isset($_GET['addevent'])) {
                        echo '<br><img src="img/members/3.jpg">';
                    }
                    elseif(isset($_GET['addmeeting'])) {
                        echo '<br><img src="img/members/2.jpg">';
                    }
                    else {
                        echo "CONNECTED";

                    }
                }

            ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
