<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/events.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/events.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container">

            <p class="topics_medium"> Events Tables </p>
            <!-- Events table -->
            <table class="eventsTables" id="general_events" >
                <script> eventsHeader(); </script>

                <?php
                    $con = makeConnection();

                    $query = "SELECT * FROM events_en";

                    if(!$result = prepareAndExecuteQuery($con,$query))
                        echo 'error reading from database... please contact admin!';

                    foreach($result as $row) {
                        $new_row = array(
                            "id"            => $row[0],
                            "date"          => $row[1],
                            "name"          => $row[2],
                            "description"   => $row[3]);

                        echo   '<tr onmousedown="open_eventPage('.$new_row["id"]. ');">
                                <td> ' . $new_row["date"] . ' </td>
                                <td> ' . $new_row["name"] . ' </td>
                                <td> ' . $new_row["description"] . ' </td>
                                <td> click here </td>
                                </tr>';
                    }
                ?>
            </table>

            <br><br>

            <p class="topics_medium"> Meeting Tables </p>
            <!-- Meetings table -->
            <table class="eventsTables" id="meetings_events">
                <script> eventsHeader(); </script>
                <?php
                    $query = "SELECT * FROM meetings_en";

                    if(!$result = prepareAndExecuteQuery($con,$query))
                        echo 'error reading from database... please contact admin!';

                    foreach($result as $row) {
                        $new_row = array(
                            "id"            => $row[0],
                            "date"          => $row[1],
                            "name"          => $row[2],
                            "description"   => $row[3]);

                        echo   '<tr onmousedown="open_meetingPage('.$new_row["id"]. ');">
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

    <?php require 'templates/footer.php' ?>

</body>
</html>
