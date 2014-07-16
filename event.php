<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/events.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/modal.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/modal.js"></script>
    <?php require './con_util.php' ?>

</head>

<body>
    <?php require 'templates/navbar.php'?>
    <?php include 'templates/modal.php' ?>

    <div id="container_center">
        <div class="container">
            <?php
                $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
                $type = isset($_GET["type"]) ? $_GET["type"] : 0;

                if($id && $type) {

                    $con;
                    set_con($con);

                    $columns = "id , name , date , text , number_of_pics";

                    $prepare_query = 'SELECT ' . $columns .
                                     ' FROM ' . ($type == 'events' ? "events" : "meetings") . '_en WHERE id=?';

                    if($query = $con->prepare($prepare_query)) {
                        $query->bind_param("i",$id);
                        $query->execute();
                        $query->bind_result($id_col,$name,$date,$text,$numOfImages);
                        $query->fetch();

                        if(!$id_col) {
                            echo $type . ' is not found in db... please contact admin!';
                            exit();
                        }

                        echo   '<p class="events_tablesName">' . $name . '<br>' . $date . '</p><hr>
                                <p class="text">' . $text . '</p>';

                    } else {
                        echo "Error #20 - Problem with statement.";
                        exit();
                    }

                } else {
                    echo "Error #21 - Missing argument.";
                    exit();
                }
            ?>
            <br>
            <div id="imageTable" class="imageTable"></div>

        </div>
    </div>

    <?php
        echo '<script> loadData("#imageTable","' . $type .'",'. $id .','. $numOfImages . '); </script>';
    ?>

    <?php require 'templates/footer.php' ?>

</body>
</html>
