<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>About us</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/aboutus.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php include_once("analyticstracking.php") ?>
    <?php require 'templates/navbar.php'?>
    <script src="./js/aboutus.js"></script>

    <div id="container_center">
        <div class="container">
            <div class="AssociationInfo">

                <p><h2 id="who_are_we_tag">Who are we?</h2></p>
                <p>
                    Costa Rica (Listeni/ˌkoʊstə ˈriːkə/, meaning "rich coast" in Spanish),
                    officially the Republic of Costa Rica (Spanish: Costa Rica or República de Costa Rica,
                    pronounced: [reˈpuβlika ðe ˈkosta ˈrika]), is a country in Central America,
                    bordered by Nicaragua to the north, Panama to the southeast, the Pacific Ocean to the
                    west, the Caribbean Sea to the east, and Ecuador to the south of Cocos Island.<br><br>
                </p>

                <hr>
                <p><h2 id="members_tag">Board of Directors</h2></p>

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
                        
                            echo   '<tr>
                                        <td  onmousedown="open_aboutPage('.$new_row["id"]. ');">
                                            <img id="myPic" src=./img/members/' .  $new_row["picPath"] . ' /> </td>
                                        <td  onmousedown="open_aboutPage('.$new_row["id"]. ');">
                                            ' . $new_row["name"] . ' </td>
                                        <td  onmousedown="open_aboutPage('.$new_row["id"]. ');">
                                            ' . $new_row["position"] . ' </td>
                                        <td onmousedown="contact_member('.$new_row["id"].');" align="center">
                                            <img src="./img/icons/email.png" height="40" width="40" alt="email"/> </td>
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
