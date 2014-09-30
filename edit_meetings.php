<?php
    include_once 'utils/control_panel_functions.php';
    securedSessionStart();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Edit meetings</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/browser.css">
    <link rel="stylesheet" href="./css/tabs.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/browser.js"></script>
    <script src="js/tabs.js"></script>
    <script src="js/events/edit_events.js"></script>
    <?php require 'utils/files.php' ?>
</head>

<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbarpannel.php'?>

    <div id="container_center">
        <div class="container">

            <?php
                if(!loggedIn()) {
                    header('Location: login.php');
                } else {
                    $directoryPath   = "img/events/meetings/";
                    $eventType = "Meeting";
                    $editEvent = isset($_POST['editEvent']) ? $_POST['editEvent'] : false;

                    require_once 'utils/edit_events_functions.php';

                }
            ?>

            <div class="tabs">

                <ul class="tab-links">
                    <li <?php echo $editEvent ? '' : 'class="active"' ?>><a href="#tab1">Add Meeting</a></li>
                    <li <?php echo $editEvent ? 'class="active"' : '' ?>><a href="#tab2">Edit Meeting</a></li>
                </ul>

                <div class="tab-content">
                    <div id="tab1" class="tab <?php echo $editEvent ? '' : 'active' ?>">
                        <?php include 'templates/events/add_event_form.php' ?>
                    </div>

                    <div id="tab2" class="tab <?php echo $editEvent ? 'active' : '' ?>">
                        <?php include 'templates/events/edit_event_form.php' ?>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>


