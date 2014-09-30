<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Subscribe</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/events.css">
    <link rel="stylesheet" href="./css/subscribe.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./js/subscribe/subscribe.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/general_utils.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">

            <?php require_once 'utils/subscribe_functions.php'; ?>

            <div class="topics_medium" id="publications">Bulletin & Newspaper</div><br>

            <div class="publications_box">
                <?php print_subscriptions_tables(); ?>
            </div>

            <br><br><br><br><br><hr><br>


            <div class="topics_medium">Subscribe Now.</div>

            <?php
                $showForm = true;
                if($showForm) {
                    include 'templates/subscribe_form.php';
                }
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
