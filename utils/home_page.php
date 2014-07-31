            <div class="multi_box"> 
                <div class="main_box main_col_box">
                    <a href="./events.php"><div class="box_header box_header_medium"> Events </div> </a>
                    <div>
            <table class="box_table">
                <?php add_events_home_page(); ?>
            </table>
                    </div>
                </div>
                <div class="main_box main_col_box" id="middle">
                    <a href="./events.php"><div class="box_header box_header_medium"> Meetings</div> </a>
                    <div>
            <table class="box_table">
                <?php add_meetings_home_page(); ?>
            </table>
                    </div>
                </div>
                <div class="main_box main_col_box">
                    <div class="box_header box_header_medium"> News </div>
                    <div class="box_text">
                        <i>"The Costa-Rica Friendship Association sends her condolences to all the familes who lost their
                            beloved ones in operation "Protective Edge"."</i>
                </div>
                </div>
            </div>

<?php

function add_events_home_page()
 {
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
 }

function add_meetings_home_page()
 {
    $con = makeConnection();
    $i=0;

    $query = "SELECT * FROM meetings_en";

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
            
        echo   '<tr onmousedown="open_meetingPage('.$new_row["id"]. ');"> 
                    <td> &bull; '.str_pad($new_row["name"],20,'.') . '</td>
                    <td>'.$new_row["date"].' </td>
                <tr>';
    }
 }
 ?>
