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

                    $sql = "UPDATE subscription 
                            SET bulletin=1 AND newsletter=1
                            WHERE email=:email;";
                    $edit_mode = true; 

                    try {
                    execute_query($con, $sql, $firstName, $lastName, $email, $bulletin, $newsletter,$edit_mode);
                    $subscribed = "Bulletin, Newsletter.";
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
