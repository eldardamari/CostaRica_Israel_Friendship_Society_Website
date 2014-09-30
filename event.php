<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Event</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/events.css">
    <link rel="stylesheet" href="./css/modal.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="./js/events/event.js"></script>
    <script src="./js/modal.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbar.php'?>
    <?php include 'templates/modal.php' ?>

    <div id="container_center">
        <div class="container">
            <?php
                $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
                $type = isset($_GET["type"]) ? $_GET["type"] : 0;

                if($id && $type) {

                    $con = makeConnection();

                    $columns = "id , name , date , text , number_of_pics";
                    $query = 'SELECT ' . $columns .
                             ' FROM ' . ($type == 'events' ? "events" : "meetings") . '_en'.
                             ' WHERE id=:id';

                    try {
                        $statement = $con->prepare($query);
                        $statement->bindParam(':id', $id);
                        $statement->execute();

                        $statement->bindColumn('id',$id_col);
                        $statement->bindColumn('name',$name);
                        $statement->bindColumn('date',$date);
                        $statement->bindColumn('text',$text);
                        $statement->bindColumn('number_of_pics',$numOfImages);

                        $statement->fetch();

                        if(!$id_col) {
                            // Error number 20 - Problem with statement
                            throw new PDOException("Event id $id - was not found",20);
                        } else {
                            $date = date("d/m/Y", strtotime($date));
                            echo   '<p class="events_tablesName">' . $name . '<br>' . $date . '</p><hr>
                                    <p class="text">' . str_replace("\n","<br>",$text) . '</p>';

                        }

                    } catch (PDOException $e) {
                        $sent = sendErrorToAdmin("event.php - DB ERROR: " . $e->getCode(), $e->getMessage());
                        echo "Error #404 - Event not found <br>";
                    }

                } else {
                    $sent = sendErrorToAdmin("event.php - Error: #21","Missing argument");
                    echo "Error #404 - Event not found <br>";
                }
            ?>

            <br>
            <div id="imageTable" class="imageTable">
                <?php

                    $imagesPath = "img/events/$type/$id/*.*";
                    $images = glob($imagesPath);
                    $j = 1;

                    foreach($images as $image) {
                        echo '<a href="#openModal" onclick="showModal(\''.$image.'\',\'1_'.$j.'\')">'.
                             '<img id="1_'.$j.'" class="thumb" src="'.$image.'"></a>';
                        $j++;
                    }
                    echo '<script> setModalTable('. $numOfImages . '); </script>';
                ?>
            </div>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
