<?php


function print_table_rows($table) {

        $func = ($table == "events_en" ? "event" : "meeting");
        $con = makeConnection();

        $query = "SELECT * FROM ".$table."
		  ORDER BY date DESC";

        if(!$result = prepareAndExecuteQuery($con,$query))
            return;

        foreach($result as $row) {
            $new_row = array(
                "id"            => $row[0],
                "date"          => date("d/m/Y", strtotime($row[1])),
                "name"          => $row[2],
                "description"   => $row[3]);

            echo   '<tr onmousedown="open_'.$func.'Page(event,'.$new_row["id"]. ');">
                    <td> ' . $new_row["date"] . ' </td>
                    <td> ' . $new_row["name"] . ' </td>
                    <td> ' . $new_row["description"] . ' </td>
                    <td> click here </td>
                    </tr>';
        }
}

?>


<table class="eventsTables" id="general_events" >
    <script> eventsHeader(); </script>
    <?php print_table_rows("events_en"); ?>
</table>

<br><br>

<div class="topics_medium"> Meeting</div>
<!-- Meetings table -->
<table class="eventsTables" id="meetings_events">
    <script> eventsHeader(); </script>
    <?php print_table_rows("meetings_en"); ?>
</table>
