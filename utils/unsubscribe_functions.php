<?php
function execute_query($con, &$sql, $email)
{
    $statement = $con->prepare($sql);

    $statement->bindParam(':email',     $email,     PDO::PARAM_STR);
    $statement->execute();
}

    if(isset($_REQUEST['email'])) {
        $email = $_REQUEST['email'];
        $mailCheck = spamCheck($email);
        if ($mailCheck == false) {
            echo "<p class='text form_error'>&emsp;Invalid email</p>";

        } else {
            $edit_mode = false;

            $con = makeConnection();

            isset($_REQUEST['bulletin'])?
                $bulletin = true : $bulletin = false;

            isset($_REQUEST['newsletter'])?
                $newsletter = true : $newsletter = false;

            $col = "";
            if($newsletter && $bulletin) {
                $col = "bulletin = 0 , newsletter = 0 ";
            } else if ($bulletin){
                $col = "bulletin = 0 ";
            } else  if($newsletter){
                $col = "newsletter = 0 ";
            }


            $sql = "UPDATE subscription 
                    SET ". $col ." 
                    WHERE email=:email;";
            try {

                execute_query($con, $sql, $email);

                echo '<p class="form_granted">&emsp;Unsubscribed Successfully 
                        <img src="/costaRicaIsrael/img/icons/green_v.png" height="20" width="20" alt="green_v"/>
                      </p>';
            
                header( "refresh:5;url=./" );


            } catch (PDOException $e) {
                echo 'Could not unsubscribe... please try again!';
                    var_dump($e->getMessage());
                }
            }
        }
