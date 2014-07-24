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
    <link rel="stylesheet" href="/costaRicaIsrael/css/browser.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="js/browser.js"></script>
    <?php require 'utils/files.php' ?>
    <?php include 'utils/edit_events_functions.php' ?>
</head>

<body onload="init('','winners/')">
    <?php require 'templates/navbarpannel.php'?>

    <div id="container_center">
        <div class="container">

            <h2>Add Events</h2>

            <?php
                if(!loggedIn()) {
                    header('Location: login.php');
                } else {

                    if(isset($_POST['delete'])) {

                        if(removePhoto($_POST['delete']))
                            echo "<script>alert('Success, photo was removed');</script>";
                        else
                            echo "<script>alert('Failure, could not delete photo');</script>";

                        header('refresh:1;url=edit_events.php');
                    }
                    if(isset($_POST['add'])) {
                        var_dump($_POST);
                    }

            ?>

                <div clase="viewer">
                    <div class="browser">
                        <div id="directoryContent" class="contents">&nbsp;</div>
                    </div>
                    <div class="preview">
                        <img id="imagePreview" class="imagePreview" />
                        <br><br>
                        <?php echo '<p id="imageName" class="text_center"></p> '?>
                        <form id="deletePhoto" method="post" action="edit_events.php">
                            <button type="submit" class="btn_default" id="action" name="delete">
                                Remove <span class="btn_icon icon_delete"></span>
                            </button>
                        </form>
                    </div>
                </div>

            <?php
                }
            ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>


