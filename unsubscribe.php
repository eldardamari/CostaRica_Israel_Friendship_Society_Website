<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Unsubscribe</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/form.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./js/subscribe/subscribe.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">
            <div class="topics"> Unsubscribe </div>

        <?php 
            require 'utils/unsubscribe_functions.php';

            require 'templates/unsubscribe_form.php';
        ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
