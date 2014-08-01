<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/events.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/subscribe.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/subscribe.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/general_utils.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">


            <div class="topics_medium">Bulletin & Newspaper</div><br>

            <div class="publications_box">
                <table class="eventsTables publications" id="newsletter_table">
                    <tr> <th class="enameCol" colspan="2"> Newletter (Hebrew) </th></tr> 
                    <tbody>
<?php

                $con = makeConnection();

                $query = "SELECT * FROM newsletter
                          ORDER BY year DESC , month DESC
                          LIMIT 0 , 6;";
                
                $result = prepareAndExecuteQuery($con,$query);

                foreach($result as $row)
                    echo '<tr> <td colspan="2">'.$row["month"].'  </td></tr>';
                    /*echo '<tr> <td colspan="2">'.$row["year"].' '.get_month($row["month"]).'  </td></tr>';*/
                
                if(sizeof($result) < 6) {
                    for ($i=0 ; $i< 6-sizeof($result) ;$i++) 
                        echo '<tr> <td colspan="2"></td></tr>';
                }
?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><button id="prev" value="-6" disabled> prev</button></td>
                        <td><button id="next" value="6"> next</button></td>
                    </tr>
                  </tfoot>
                </table>
            

                <table class="eventsTables publications" id="bulletin_table">
                    <tr> <th class="enameCol" colspan="2"> Bulletin (Español) </th></tr>
                    <tbody>
<?php

                $con = makeConnection();

                $query = "SELECT * FROM bulletin
                          ORDER BY year DESC , month DESC
                          LIMIT 0 , 6;";
                
                $result = prepareAndExecuteQuery($con,$query);

                foreach($result as $row)
                    echo '<tr> <td colspan="2">'.$row["month"].'  </td></tr>';
                    /*echo '<tr> <td colspan="2">'.$row["year"].' '.get_month($row["month"]).'  </td></tr>';*/
                
                if(sizeof($result) < 6) {
                    for ($i=0 ; $i< 6-sizeof($result) ;$i++) 
                        echo '<tr> <td colspan="2"></td></tr>';
                }
?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <td><button id="prev" value="-6" disabled> prev</button></td>
                        <td><button id="next" value="6"> next</button></td>
                    </tr>
                </tfoot>
            </table>

            </div>

            <br><br><br><br><br><hr><br>


            <div class="topics_medium">Subscribe</div>

            <?php
                $showForm = true;

                require_once 'utils/subscribe_functions.php';

                if($showForm) {

                    include 'templates/subscribe_form.php';
                }
            ?>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
