<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/events.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/modal.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/modal.js"></script>
    <?php require './con_util.php' ?>

    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
</head>

<body>
    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

    <div id="container_center">
        <div class="container">

<?php 
                $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
                $type = isset($_GET["type"]) ? $_GET["type"] : 0;

                if($id && $type) {

                $con;
                $numOfImages;
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

            echo '<p class="events_tablesName">' . $name . '<br>' . $date . '</p><hr>
            <p class="text">' . $text . '</p>';

                    } else {
                        echo '<br> <br>';
                        printf("\nproblem with statemt..: \n");
                        echo 'This is query : ' .$query;
                        exit();
                    }
                } else {
                    printf("Argument is missing..: \n");
                    exit();
                }

            echo '<br>
            <div class="imageTable"></div>

        </div>
    </div>

    <script src="/costaRicaIsrael/js/footer.js"></script>

    <div id="openModal" class="modalDialog">
        <div>
            <a href="#close" title="Close" class="close">X</a>
            <div>
                <table>
                    <tr>
                        <td onclick="toggleLeft();"> 
                            <a href="#openModal"><span class="arrow_left"></span></a> 
                        </td>

                        <td id="image"></td>

                        <td onclick="toggleRight();"> 
                            <a href="#openModal"><span class="arrow_right"></span></a> 
                        </td>
                    </tr>
                </table>

            </div>
        </div>
    </div>';

echo '<script> loadData("' . $type .'",'. $id .','. $numOfImages . '); </script>';

?>


</body>
</html>
