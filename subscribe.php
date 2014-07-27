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

                require_once 'utils/subscribe.php';

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
