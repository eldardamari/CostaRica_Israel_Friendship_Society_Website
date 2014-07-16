<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/events.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <?php require './con_util.php' ?>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
</head>

<body>

    <script src="/costaRicaIsrael/js/events.js"></script>
    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

    <div id="container_center">
        <div class="container">
            <p class="events_tablesName"> Events Tables </p>

<!-- Events table -->
            <table class="eventsTables" id="general_events" >
                <script> eventsHeader(); </script>
            <?php
                $con;
                $query = "SELECT * FROM events_en";
                $query_data = set_con_get_query_data($con,$query);
                

                while($row = mysqli_fetch_row($query_data)) {
                    $new_row = array(  
                                    "id"            => $row[0],
                                    "date"          => $row[1],
                                    "name"          => $row[2],
                                    "description"   => $row[3]);
                    echo '<tr onmousedown="open_eventPage('.$new_row["id"]. ');">
                        <td> ' . $new_row["date"] . ' </td> 
                        <td> ' . $new_row["name"] . ' </td> 
                        <td> ' . $new_row["description"] . ' </td> 
                        <td> click here </td> 
                        </tr>';
                }
            ?>
            </table>
            <br><br>
            
<!-- Meetings table -->
            <p class="events_tablesName"> Meeting Tables </p>
            <table class="eventsTables" id="meetings_events">
                <script> eventsHeader(); </script>
            <?php
                $con;
                $query = "SELECT * FROM meetings_en";
                $query_data = set_con_get_query_data($con,$query);
                

                while($row = mysqli_fetch_row($query_data)) {
                    $new_row = array(  
                                    "id"            => $row[0],
                                    "date"          => $row[1],
                                    "name"          => $row[2],
                                    "description"   => $row[3]);
                    echo '<tr onmousedown="open_meetingPage('.$new_row["id"]. ');">
                        <td> ' . $new_row["date"] . ' </td> 
                        <td> ' . $new_row["name"] . ' </td> 
                        <td> ' . $new_row["description"] . ' </td> 
                        <td> click here </td> 
                        </tr>';
                }
            ?>
            </table>
    
        </div>
    </div>

    <script src="/costaRicaIsrael/js/footer.js"></script>

</body>
</html>
