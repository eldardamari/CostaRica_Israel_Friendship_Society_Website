<?php
    include_once 'utils/control_panel_functions.php';
    securedSessionStart();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Edit subscriptions</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/form.css">
    <link rel="stylesheet" href="./css/browser.css">
    <link rel="stylesheet" href="./css/tabs.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/browser.js"></script>
    <script src="js/tabs.js"></script>
    <script src="js/winners/edit_winner.js"></script>
    <script src="js/winners/add_winner.js"></script>
    
    <script src="js/subscribe/subscribe.js"></script>
    <script src="js/subscribe/edit_subscribe.js"></script>
    
    <?php require 'utils/files.php' ?>
    <?php require 'utils/general_utils.php' ?>
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
                    require_once 'utils/edit_subscriptions_functions.php';
                }
            ?>

            <div class="tabs">

                <ul class="tab-links">
                    <li <?php echo ($edit_mode ? '' : 'class="active"'); ?>><a href="#tab1">Add Subscription</a></li>
                    <li <?php echo ($edit_mode ? 'class="active"' : ''); ?>><a href="#tab2">Edit Subscription</a></li>
                </ul>

                <div class="tab-content">
                    <div id="tab1" class="tab <?php echo ($edit_mode ? '' : 'active'); ?>">
                        <?php include './templates/subscribe/add_subscription_form.php' ?>
                    </div>

                    <div id="tab2" class="tab <?php echo ($edit_mode ? 'active' : '' ); ?>">
                        <?php include './templates/subscribe/edit_subscription_form.php' ?>
                    </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>


