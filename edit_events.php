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
    <script src="js/events.js"></script>
    <?php require 'utils/files.php' ?>
    <?php include 'utils/edit_events_functions.php' ?>
</head>

<body onload="init('','events/events/');$('#type').attr('value','events');">
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

                        if ($_FILES['pictures']['error'] != UPLOAD_ERR_NO_FILE) {
                            $uploaded_pictures = check_multiple_files('pictures');
                        }

                        $num_of_pictures = $uploaded_pictures['num_of_pictures'];

                        $date = $_POST['date'];
                        $eventName = htmlspecialchars($_POST['eventName']);

                        $description = htmlspecialchars($_POST['description']);
                        $description = filter_var($description,FILTER_SANITIZE_STRING);

                        $text = htmlspecialchars($_POST['text']);
                        $text = filter_var($text,FILTER_SANITIZE_STRING);

                        $id = addEventToDBAndGetBackID($date, $eventName, $description, $text, $num_of_pictures);

                        $filesMoved = 0;
                        $eventType = $_POST['type'];
                        if($id) {
                            $directoryPath   = "img/events/".$eventType."/".$id;
                            $filesMoved = uploadPhotosToEvent($uploaded_pictures, $directoryPath, $num_of_pictures);

                            // in case of update
                            if($filesMoved != $num_of_pictures)
                                updateNumOfPics($filesMoved);

                            echo '<p class="form_granted">&emsp;Event added successfully!
                                    <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/></p>';

                        } else {
                            echo "<p class='text form_error'>&emsp;
                                    Failed updating database..please try again.";
                        }

                    }
                    include 'templates/add_event_form.php';
            ?>
                <br><br>
                <div clase="viewer">
                    <div class="browser">
                        <div id="directoryContent" class="contents">&nbsp;</div>
                    </div>
                    <div class="preview">
                        <img id="imagePreview" class="imagePreview" />
                        <br>
                        <?php echo '<p id="imageName" class="text_center"></p> '?>
                        <form id="deletePhoto" class="general_form" method="post" action="edit_events.php">
                            <button type="submit" class="btn_default" id="action" name="delete">
                                <span class="btn_icon icon_delete"></span> Remove
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


