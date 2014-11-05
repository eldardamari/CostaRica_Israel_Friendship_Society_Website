
            <div class="main_box main_col_box multi_box">
                <div class="split_box">
                    <a href="./subscribe.php#publications">
                        <div class="box_header box_header_medium"> Newsletters (Hebrew)</div></a>
                    <table class="box_table newsletter_box">
                <?php add_newsletter_bulletin_home_page("newsletter"); ?>
            </table>
                </div>
                <div>
                    <a href="./subscribe.php#publications">
                        <div class="box_header box_header_medium"> Bulletin (Español)</div></a>
            <table class="box_table bulletin_box">
                <?php add_newsletter_bulletin_home_page("bulletin"); ?>
            </table>
                </div>
            </div>

                <div id="text_box" lang="en">
                    <div id="text_box_header"> <strong>Israel - Costa Rica Friendship Association</strong></div>
                <!--<div id="text_box_body">
		Israel - Costa Rica Friendship Assoc. a non-profit organization, established at july 30,1984 
		by a group of pioneers from Costa-Rica & south america countries.Believing in the state of Israel and the maintaining relationship with both countries. Both communities living in Costa-Rica and Israel can keep a close relations with each other. The association conduct a unique yearly program:"Know Costa-Rica Contest" an opportunity for students in Israel to explorer Costa-Rica in a unique way.
                </div>-->
                

		<div id="text_box_body">
			The "Israel - Costa Rica Friendship Association" is a non-profit
			organization established in July 30, 1984 by a group of pioneers from
			Costa-Rica and South American countries with the purpose of
			cultivating warm and close relations between both countries at a
			person to person level.
			<br><br>
			The Association conducts with great success a
			yearly Quiz Program: "Know Costa-Rica Contest", an opportunity for
			Israeli students to explore Costa-Rica in a unique way.
		</div>
            </div>






<div class="multi_box"> 
                <div class="main_box main_col_box">
                    <a href="./events.php"><div class="box_header box_header_medium"> Events </div> </a>
                    <div>
            <table class="box_table">
                <?php add_events_meetings_home_page("event"); ?>
            </table>
                    </div>
                </div>
                <div class="main_box main_col_box" id="middle">
                    <a href="./events.php"><div class="box_header box_header_medium"> Meetings</div> </a>
                    <div>
            <table class="box_table">
                <?php add_events_meetings_home_page("meeting"); ?>
            </table>
                    </div>
                </div>
                <div class="main_box main_col_box">
                    <div class="box_header box_header_medium"> News </div>
                    <div class="box_text">
                        <!--<i> "The Costa-Rica Friendship Association sends her condolences to all the familes who lost their
                            beloved ones in operation "Protective Edge"."
                        </i> -->
<i> "The Costa-Rica Friendship Association news here! <br> 
                        </i> 
                </div>
                </div>
            </div>

            <br>
            <div class="main_box" id="partners">
                <div class="box_header box_header_large"> Collaborators </div>
                <div> 
                    <a href="http://www.student.co.il/" target="_blank">
                        <img src="./img/partners/tau.png" height="169" width="255" ></a>
                    <a href="http://en.allalouf.com/" target="_blank">
                        <img src="./img/partners/allalouf.png" height="74" width="277" ></a>
                    <a href="http://www.proimagen.cr/en" target="_blank">
                        <img src="./img/partners/proimagen.png" height="107" width="312" ></a>
                    <a href="http://mfa.gov.il/MFA/Pages/default.aspx" target="_blank">
                        <img src="./img/partners/imf.png" height="140" width="150" ></a>
                    <a href="http://google.co.il" target="_blank">
                        <img src="./img/partners/cremb.png" height="208" width="188" ></a>
                    <a href="http://www.rree.go.cr/" target="_blank"> 
                        <img src="./img/partners/crmf.png" height="100" width="200" ></a>
                    <a href="http://embassies.gov.il/san-jose/Pages/default.aspx" target="_blank">
                        <img src="./img/partners/iemb.png" height="50" width="400" ></a>
                </div>
            </div>

<?php

function add_events_meetings_home_page($table)
 {
    $con = makeConnection();
    $i=0;

    $table = ($table == "event" ? "event" : "meeting");

    $query = "SELECT * FROM ".$table."s_en 
	      ORDER BY date DESC";

    $result = prepareAndExecuteQuery($con,$query);

    if( sizeof($result) == 0) {
        sendErrorToAdmin("home_page event/meetings boxes - failed","result is empty from SELECT * FROM ".$table);
        return;
    }

    foreach($result as $row) {
        if($i++ == 5) {
            break;
        }
        $new_row = array(
            "id"            => $row[0],
            "date"          => date("d/m/Y", strtotime($row[1])),
            "name"          => $row[2]);

        if (strlen($new_row["name"]) >= 22) {
            $new_row["name"] = substr(ucwords($new_row["name"]),0,19).'..';
        }
            
        echo   '<tr onmousedown="open_'.$table.'Page(event,'.$new_row["id"]. ');"> 
                    <td> &bull; '.$new_row["name"]. '</td>
                    <td>'.$new_row["date"].' </td>
                <tr>';
    }
 }

function add_newsletter_bulletin_home_page($table)
 {
    $con = makeConnection();
    $i=0;

    $table = ($table == "newsletter" ? "newsletter" : "bulletin");

    $query = "SELECT * FROM ".$table."
              ORDER BY year DESC , month DESC
              LIMIT 0 , 2;";

    $result = prepareAndExecuteQuery($con,$query);

    if( sizeof($result) == 0) {
        sendErrorToAdmin("home_page newsletter/bulletin boxes - failed","result is empty from SELECT * FROM ".$table);
        return;
    }

    foreach($result as $row) {
        if($i++ == 2) {
            break;
        }
        $type = "doc";

        if (strpos($row["file_name"],"pdf"))
            $type = "pdf";
        echo '<tr onmousedown=download_'.$table.'(event,"'.$row["file_name"].'") ><td> &bull; <img src="./img/browser/'.$type.'.png" height="14" width="14"> '
        . $row["year"]  . ' ' . get_month($row["month"]) . ' (#' . $row["catalog"] . ')</td></tr>';
    }
 }

