<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/events.js"></script>
    <?php require 'utils/db_connection.php' ?>

</head>
<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container text">

            <?php include 'templates/slide_show.php' ?>

            <p lang="en">
                <strong>Costa-Rica Israel Friendship Association - English </strong>
                <br><br>
                Costa Rica (Listeni/ˌkoʊstə ˈriːkə/, meaning "rich coast" in Spanish), officially
                the Republic of Costa Rica (Spanish: Costa Rica or República de Costa Rica,
                pronounced: [reˈpuβlika ðe ˈkosta ˈrika]), is a country in Central America, bordered
                by Nicaragua to the north, Panama to the southeast, the Pacific Ocean to the west,
                the Caribbean Sea to the east, and Ecuador to the south of Cocos Island.
                <br><br>
            </p>

            <div class="multi_box"> 
                <div class="main_box main_col_box">
                    <a href="./events.php"><div class="box_header box_header_medium"> Events </div> </a>
                    <div>
            <table class="box_table">
                <?php
                    $con = makeConnection();
                    $i=0;

                    $query = "SELECT * FROM events_en";

                    if(!$result = prepareAndExecuteQuery($con,$query))
                        echo 'error reading from database... please contact admin!';

                    foreach($result as $row) {
                        if($i++ == 5) {
                            break;
                        }
                        $new_row = array(
                            "id"            => $row[0],
                            "date"          => $row[1],
                            "name"          => $row[2]);

                        if (strlen($new_row["name"]) >= 20) {
                            $new_row["name"] = substr($new_row["name"],0,17);
                        }
                            
                        echo   '<tr onmousedown="open_eventPage('.$new_row["id"]. ');"> 
                                    <td> &bull; '.str_pad($new_row["name"],20,'.') . '</td>
                                    <td>'.$new_row["date"].' </td>
                                <tr>';
                    }
                ?>
            </table>
                    </div>
                </div>
                <div class="main_box main_col_box" id="middle">
                    <a href="./events.php"><div class="box_header box_header_medium"> Meetings</div> </a>
                    <div>
            <table class="box_table">
                <?php
                    $con = makeConnection();
                    $i=0;

                    $query = "SELECT * FROM meetings_en";

                    if(!$result = prepareAndExecuteQuery($con,$query))
                        echo 'error reading from database... please contact admin!';

                    foreach($result as $row) {
                        if($i++ == 5) {
                            echo $i;
                            break;
                        }
                        $new_row = array(
                            "id"            => $row[0],
                            "date"          => $row[1],
                            "name"          => $row[2]);

                        if (strlen($new_row["name"]) >= 20) {
                            $new_row["name"] = substr($new_row["name"],0,17);
                        }
                            
                        echo   '<tr onmousedown="open_meetingPage('.$new_row["id"]. ');"> 
                                    <td> &bull; '.str_pad($new_row["name"],20,'.') . '</td>
                                    <td>'.$new_row["date"].' </td>
                                <tr>';
                    }
                ?>
            </table>
                    </div>
                </div>
                <div class="main_box main_col_box">
                    <div class="box_header box_header_medium"> Newspaper </div>
                    Cuenta con 4,889,826 de habitantes según el último censo de población.
                    1 Su territorio, con un área total de 51.100 km², es bañado al este por el mar Caribe y al
                </div>
            </div>
            <br>
            <div class="main_box" id="partners">
                <div class="box_header box_header_large"> Partners </div>
                <div> 
                    <a href="http://mfa.gov.il/MFA/Pages/default.aspx" target="_blank">
                        <img src="./img/partners/imf.jpg" height="118" width="100" ></a>
                    <a href="http://www.rree.go.cr/" target="_blank"> 
                        <img src="./img/partners/crmf.png" height="100" width="200" ></a>
                    <a href="http://embassies.gov.il/san-jose/Pages/default.aspx" target="_blank">
                        <img src="./img/partners/iemb.png" height="50" width="400" ></a>
                    <a href="http://english.tau.ac.il/" target="_blank">
                        <img src="./img/partners/tau.png" height="54" width="256" ></a>
                        <a href="http://en.allalouf.com/" target="_blank">
                        <img src="./img/partners/allalouf.png" height="74" width="277" ></a>
                    <a href="http://www.proimagen.cr/en" target="_blank">
                        <img src="./img/partners/proimagen.png" height="107" width="312" ></a>
                    <a href="http://www.ophirtours.co.il/" target="_blank">
                        <img src="./img/partners/ophir_tours.jpg" height="88" width="288" ></a>
                </div>
            </div>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
