<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Israel-Costa Rica Friendship Assoc.</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/events.js"></script>
    <script src="/costaRicaIsrael/js/index.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
    <?php require 'utils/general_utils.php' ?>

</head>
<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container text">

            <?php include 'templates/slide_show.php' ?>

            <?php include 'utils/home_page.php' ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
