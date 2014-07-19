<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>

    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/contest.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/modal.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/contest.js"></script>
    <script src="/costaRicaIsrael/js/modal.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>
    <?php include 'templates/modal.php' ?>

    <div id="container_center">
        <div class="container">
            <div class="topics"> Registration </div>

            <?php include 'templates/contest_form.php' ?>

            <br><hr><br>

            <div class="topics"> Know The Winners </div>

            <?php

                $con = makeConnection();
                $row_count = 0;

                $query = "SELECT * FROM winners_en
                          ORDER BY contest_num DESC , place ASC";
                
                if(!$result = prepareAndExecuteQuery($con,$query))
                    echo 'error reading from database... please contact admin!';

                foreach($result as $row) {
                    $new_row = array(
                        "contest_num"       => $row[0],
                        "id"                => $row[1],
                        "name"              => $row[2],
                        "subject"           => $row[3],
                        "institute"         => $row[4],
                        "number_of_pics"    => $row[5],
                        "place"             => $row[6],
                        "pic_path"          => $row[7]);

                    if ($row_count == 0) {
                        echo '<br><h2 align="center">' . (2005 + $new_row["contest_num"]) .'
                        Contest Winneres - #' . $new_row["contest_num"].'</h3>

                        <table class="winnersTable" id="winners_'.$new_row["contest_num"].'">
                                <script> eventsHeader(); </script>';
                    }

                    echo '<tr>
                        <td> ' . ($new_row["place"] == 1 ? '1st' : '2nd') . '</td>
                        <td> <img id="myPic" src=./img/winners/' .
                        $new_row["contest_num"] . '/' . $new_row["pic_path"] . ' /> </td>
                            <td> ' . $new_row["name"] . ' </td>
                            <td> ' . $new_row["subject"] . ' </td>
                            <td> ' . $new_row["institute"] . ' </td>
                        </tr>';

                    if ($row_count == 1) {
                        echo '
                            <tr>
                                <td colspan="5" class="imageTable_'.$new_row["contest_num"].' imageTable"></td>
                            </tr>
                            </table>
                            <script> loadData(".imageTable_'.$new_row["contest_num"].'",
                                              "winners",
                                              '.$new_row["contest_num"].',
                                              '.$new_row["number_of_pics"].');
                            </script> ';
                        $row_count = 0;

                    } else if ($row_count == 0) {
                        $row_count = 1;
                    }
                }

                if ($row_count == 1) {
                    echo '
                        <tr>
                            <td colspan="5" class="imageTable_'.$new_row["contest_num"].' imageTable"></td>
                        </tr>
                        </table>
                        <script> loadData(".imageTable_'.$new_row["contest_num"].'",
                                          "winners",
                                          '.$new_row["contest_num"].',
                                          '.$new_row["number_of_pics"].');
                        </script> ';
                    $row_count = 0;
                }
            ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
