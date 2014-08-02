<?php
function execute_query($con, &$sql, $firstName, $lastName, $email, $bulletin, $newsletter,$edit_mode)
{
    $statement = $con->prepare($sql);

    if ($edit_mode) {
        $statement->bindParam(':email',     $email,     PDO::PARAM_STR);
    } else {
        $statement->bindParam(':first_name',$firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName,  PDO::PARAM_STR);
        $statement->bindParam(':email',     $email,     PDO::PARAM_STR);
        $statement->bindParam(':bulletin',  $bulletin,  PDO::PARAM_BOOL);
        $statement->bindParam(':newsletter',$newsletter,PDO::PARAM_BOOL);
    }
    $statement->execute();
}

function print_subscriptions_data_rows_for($table) {

    $res = "";
    $con = makeConnection();

    $query = "SELECT * FROM ".$table."
              ORDER BY year DESC , month DESC
              LIMIT 0 , 6;";
    
    $result = prepareAndExecuteQuery($con,$query);

    foreach($result as $row)
        $res.= '<tr data-filename="'.$row["file_name"].'"><td colspan=2 > <img src="./img/icons/doc.png" height="22" width="22"> '
        . $row["year"]  . ' ' . get_month($row["month"]) . ' (' . $row["catalog"] . ')</td></tr>';
    
    if(sizeof($result) < 6) {
        for ($i=0 ; $i< 6-sizeof($result) ;$i++) 
            $res.= '<tr> <td colspan="2"></td></tr>';
    }

    return $res;
}

function print_subscriptions_tables() {

    echo '<table class="eventsTables publications" id="newsletter_table">
        <thead> <tr> <th colspan="2"> Newletter (Hebrew) </th></tr> </thead>
        <tbody>'.
        print_subscriptions_data_rows_for("newsletter").'
    </tbody>
    <tfoot>
        <tr>
        <td id="prev" data-page="-6"><img src="./img/icons/prev.png" height="22" width="22"></td>
        <td id="next" data-page="6"><img src="./img/icons/next.png" height="22" width="22"></td>
        </tr>
      </tfoot>
    </table>


    <table class="eventsTables publications" id="bulletin_table">
    <thead><tr> <th class="enameCol" colspan="2"> Bulletin (Español) </th></tr></thead>
        <tbody>'.
        print_subscriptions_data_rows_for('bulletin').'
        </tbody>

        <tfoot>
        <tr>
        <td id="prev" data-page="-6"><img src="./img/icons/prev.png" height="22" width="22"></td>
        <td id="next" data-page="6"><img src="./img/icons/next.png" height="22" width="22"></td>
        </tr>
    </tfoot>
</table>';
}


    if(isset($_REQUEST['email'])) {
        $email = $_REQUEST['email'];
        $mailCheck = spamCheck($email);
        if ($mailCheck == false) {
            echo "<p class='text form_error'>&emsp;Invalid email</p>";

        } else {
            $showForm = false;
            $edit_mode = false;

            $con = makeConnection();

            $firstName  = $_REQUEST['first_name'];
            $lastName   = $_REQUEST['last_name'];

            isset($_REQUEST['bulletin'])?
                $bulletin = true : $bulletin = false;

            isset($_REQUEST['newsletter'])?
                $newsletter = true : $newsletter = false;

            $subscribed = "";
            $bulletin   ? $subscribed .= "Bulletin, &emsp;" : "";
            $newsletter ? $subscribed .= "Newsletter" : $subscribed = substr($subscribed,0,8);

            $sql = "INSERT INTO subscription(first_name,last_name,email,bulletin,newsletter)
                        VALUES (:first_name, :last_name, :email, :bulletin, :newsletter)";
            try {

                execute_query($con, $sql, $firstName, $lastName, $email, 
                                $bulletin, $newsletter,$edit_mode);
                sendWelcomeMail($email,$firstName,$lastName,$subscribed);

                echo '<p class="form_granted">&emsp;Subscribed Successfully : '.$subscribed .'
                        <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>
                      </p>';

                $showForm = true;

            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    $col = "";
                    if($newsletter && $bulletin) {
                        $col = "bulletin = 1 , newsletter = 1 ";
                    } else if ($bulletin){
                        $col = "bulletin = 1 ";
                    } else  if($newsletter){
                        $col = "newsletter = 1 ";
                    }

                    $sql = "UPDATE subscription 
                            SET ".$col." 
                            WHERE email=:email;";
                    $edit_mode = true; 

                    try {
                    execute_query($con, $sql, $firstName, $lastName, $email, $bulletin, $newsletter,$edit_mode);
                    sendWelcomeMail($email,$firstName,$lastName,$subscribed);
                    $showForm = true;
                
                    echo '<p class="form_granted">&emsp;Update Subscribtion Successfully : '.$subscribed .'
                        <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>
                      </p>';

                } catch (PDOException $e) {
                    echo 'could not subscribe... please contact admin!';
                    var_dump($e->getMessage());
                    $showForm = true;
                }
                } else {
                    echo 'could not subscribe... please contact admin!';
                    var_dump($e->getMessage());
                }
                $showForm = true;
            }

        }
    }
