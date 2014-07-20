<?php

function print_table_head($new_row)
{
    echo '<br><h2 align="center">' . (2005 + $new_row["contest_num"]) .'
        Contest Winneres - #' . $new_row["contest_num"].'</h3>

        <table class="winnersTable" id="winners_'.$new_row["contest_num"].'">
        <script> eventsHeader(); </script>';
}

function print_winner_row($new_row)
{
    echo '<tr>
        <td> ' . ($new_row["place"] == 1 ? '1st' : '2nd') . '</td>
        <td> <img id="myPic" src=./img/winners/' .
        $new_row["contest_num"] . '/' . $new_row["pic_path"] . ' /> </td>
        <td> ' . $new_row["name"] . ' </td>
        <td> ' . $new_row["subject"] . ' </td>
        <td> ' . $new_row["institute"] . ' </td>
        </tr>';
}
function print_winner_end_table($new_row)
{
    echo '
        <tr>
        <td colspan="5" class="imageTable_'.$new_row["contest_num"].' imageTable"></td>
        </tr>
        </table>
        <script> loadData(".imageTable_'.$new_row["contest_num"].'",
                            "winners",
                            '.$new_row["contest_num"].',
                            '.$new_row["number_of_pics"].');
                                                        </script> ';
}

function print_winner_prev_end_table($prev_contect_num,$prev_num_pics)
{
    echo '
        <tr>
        <td colspan="5" class="imageTable_'.$prev_contect_num.' imageTable"></td>
        </tr>
        </table>
        <script> loadData(".imageTable_'.$prev_contect_num.'",
                            "winners",
                            '.$prev_contect_num.',
                            '.$prev_num_pics.');
                            </script> ';
}
