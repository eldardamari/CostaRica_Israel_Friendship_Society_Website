<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Israel-Costa Rica Friendship Assoc.</title>
    <link rel="stylesheet" href="./css/main.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./js/events/events.js"></script>
    <script src="./js/index.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
    <?php require 'utils/general_utils.php' ?>

</head>
<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container text">
            
	<?php //include 'templates/slide_show.php' ?>

	    <div class="auto-resizable-iframe">
		<div>
		    <div id="player"> </div>
		</div>
	    </div>


            <?php include 'utils/home_page.php' ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
