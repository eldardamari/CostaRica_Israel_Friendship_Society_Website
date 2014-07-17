<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/aboutus.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>
    <script src="/costaRicaIsrael/js/aboutus.js"></script>

    <div id="container_center">
        <div class="container">
            <div class="AssociationInfo">

                <p><h2>Who are we?</h2></p>
                <p>
                    Costa Rica (Listeni/ˌkoʊstə ˈriːkə/, meaning "rich coast" in Spanish),
                    officially the Republic of Costa Rica (Spanish: Costa Rica or República de Costa Rica,
                    pronounced: [reˈpuβlika ðe ˈkosta ˈrika]), is a country in Central America,
                    bordered by Nicaragua to the north, Panama to the southeast, the Pacific Ocean to the
                    west, the Caribbean Sea to the east, and Ecuador to the south of Cocos Island.<br><br>
                </p>

                <hr>
                <p><h2>Members</h2></p>

                <table class="membersTable" id="members_table" >

                    <script> eventsHeader(); </script>

                    <?php
                        $con = makeConnection();

                        $query = "SELECT * FROM members";

                        if(!$result = prepareAndExecuteQuery($con,$query))
                            echo 'error reading from database... please contact admin!';

                        foreach($result as $row) {
                            $new_row = array(
                                            "name"        => $row[0],
                                            "id"          => $row[1],
                                            "position"    => $row[2],
                                            "email"       => $row[3],
                                            "tel_number"  => $row[4],
                                            "picPath"     => $row[5]);

                            if ($new_row["id"] == 0) // Competition memeber -> skip
                                continue;
                        
                            echo   '<tr onmousedown="open_abomePage('.$new_row["id"]. ');">
                                        <td> <img id="myPic" src=./img/members/' .  $new_row["picPath"] . ' /> </td>
                                        <td> ' . $new_row["name"] . ' </td>
                                        <td> ' . $new_row["position"] . ' </td>
                                        <td> ' . $new_row["email"] . ' </td>
                                    </tr>';
                        }
                    ?>

                </table>

            </div>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
