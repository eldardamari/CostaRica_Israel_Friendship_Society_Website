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
    <?php require 'utils/contest_functions.php' ?>
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

                $prev_contest_num = 0;
                $prev_num_pics = 0;
                $second = false;
                $i = 1;

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

                    if($prev_contest_num - 1 == $new_row['contest_num']) {
                        print_winner_prev_end_table($prev_contest_num, $prev_num_pics, $i);
                        $i++;
                    }

                    if($new_row['place'] == 1) {
                        print_table_head($new_row);
                        print_winner_row($new_row);
                        $prev_contest_num = (int)$new_row["contest_num"];
                        $prev_num_pics    = (int)$new_row["number_of_pics"];
                        $second = false;
                    }

                    if($new_row['place'] == 2) {
                        print_winner_row($new_row);
                        $second = true;
                    }
                }
                if(!$second) {
                    print_winner_prev_end_table($prev_contest_num, $prev_num_pics, $i);
                } else {
                    print_winner_end_table($new_row,$i);
                }
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
