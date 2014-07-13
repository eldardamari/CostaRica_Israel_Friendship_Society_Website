<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/events.css">
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
            
<!-- 2nd table -->
            <p class="events_tablesName"> Meeting Tables </p>
            <table class="eventsTables" id="meetings_events">
                <script> eventsHeader(); </script>
            </table>
    
            <script> insertDataToTable("meetings_events"); </script>
            <button onclick='insertDataToTable("meetings_events")'>Add row </button>
        </div>
    </div>

    <script src="/costaRicaIsrael/js/footer.js"></script>

</body>
</html>
