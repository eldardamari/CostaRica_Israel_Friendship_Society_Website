<?php
    include_once 'utils/control_panel_functions.php';
    securedSessionStart();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/tabs.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/tabs.js"></script>
    <script src="js/members/edit_member.js"></script>
    <script src="js/members/add_member.js"></script>
    <?php require 'utils/files.php' ?>
</head>

<body>
    <?php require 'templates/navbarpannel.php'?>

    <div id="container_center">
        <div class="container">

            <?php

                if(!loggedIn()) {

                    header('Location: login.php');

                } else {

                    require_once 'utils/edit_members_functions.php';
                }
            ?>
            <div class="tabs">

                <ul class="tab-links">
                    <li <?php echo ($edit_mode ? '' : 'class="active"'); ?>><a href="#tab1">Add Member</a></li>
                    <li <?php echo ($edit_mode ? 'class="active"' : ''); ?>><a href="#tab2">Edit Member</a></li>
                </ul>

                <div class="tab-content">
                    <div id="tab1" class="tab <?php echo ($edit_mode ? '' : 'active'); ?>">
                        <?php include './templates/members/add_member_form.php' ?>
                    </div>

                    <div id="tab2" class="tab <?php echo ($edit_mode ? 'active' : '' ); ?>">
                        <?php include './templates/members/edit_member_form.php' ?>
                    </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>


