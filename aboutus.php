<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/aboutus.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <?php require './con_util.php' ?>

    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
</head>

<body>
    <script src="/costaRicaIsrael/js/aboutus.js"></script>
    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

    <div id="container_center">
        <div class="container">
            <div class="AssociationInfo">
                <p><h2>Who are we?</h2></p>
                <p> 
                Costa Rica (Listeni/ˌkoʊstə ˈriːkə/, meaning "rich coast" in Spanish), officially the Republic of Costa Rica (Spanish: Costa Rica or República de Costa Rica, pronounced: [reˈpuβlika ðe ˈkosta ˈrika]), is a country in Central America, bordered by Nicaragua to the north, Panama to the southeast, the Pacific Ocean to the west, the Caribbean Sea to the east, and Ecuador to the south of Cocos Island.<br><br>
                </p>

                <hr>
                <p><h2>Members</h2></p>
                <table class="membersTable" id="members_table" >
                <script> eventsHeader(); </script>

            <?php
                $con;
                $query = "SELECT * FROM members";
                $query_data = set_con_get_query_data($con,$query);
                

                while($row = mysqli_fetch_row($query_data)) {
                    $new_row = array(  
                                    "name"        => $row[0],
                                    "id"          => $row[1],
                                    "position"    => $row[2],
                                    "email"       => $row[3],
                                    "tel_number"  => $row[4],
                                    "picPath"     => $row[5]);
                    echo '<tr onmousedown="open_abomePage('.$new_row["id"]. ');">
                        <td> <img id="myPic" src=./img/' .  $new_row["picPath"] . 
                        ' /> </td> 
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

    <script src="/costaRicaIsrael/js/footer.js"></script>

</body>
</html>
