<?php

function print_table_head($new_row)
{
    echo '<br><h2 align="center">' . (2005 + $new_row["contest_num"]) .'
        Contest Winners - #' . $new_row["contest_num"].'</h3>'.
        '<table class="winnersTable" id="winners_'.$new_row["contest_num"].'">'.
        '<script> eventsHeader(); </script>';
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
function print_winner_end_table($new_row,$i)
{
    $imagesPath = "./img/winners/".$new_row['contest_num']."/[winner_]*.*";
    $images = glob($imagesPath);
    $j = 1;

    echo '<tr><td colspan="5" class="imageTable_'.$new_row["contest_num"].' imageTable">';
    foreach($images as $image) {
        echo '<a href="#openModal" onclick="showModal(\''.$image.'\',\''.$i.'_'.$j.'\')">'.
            '<img id="'.$i.'_'.$j.'" class="thumb" src="'.$image.'"></a>';
        $j++;
    }
    echo '</td></tr></table>';
    echo '<script> setModalTable('. $new_row["number_of_pics"] . '); </script>';
}

function print_winner_prev_end_table($prev_contect_num, $prev_num_pics, $i)
{
    /*$imagesPath = "img/winners/".$prev_contect_num."/[0-9]*.*";*/
    $imagesPath = "./img/winners/".$prev_contect_num."/[winner_]*.*";
    $images = glob($imagesPath);
    $j = 1;

    echo '<tr><td colspan="5" class="imageTable_'.$prev_contect_num.' imageTable">';
    foreach($images as $image) {
        echo '<a href="#openModal" onclick="showModal(\''.$image.'\',\''.$i.'_'.$j.'\')">'.
            '<img id="'.$i.'_'.$j.'" class="thumb" src="'.$image.'"></a>';
        $j++;
    }
    echo '</td></tr></table>';
    echo '<script> setModalTable('. $prev_num_pics . '); </script>';
}
