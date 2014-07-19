<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>

    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/contest.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/modal.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/contest.js"></script>
    <script src="/costaRicaIsrael/js/modal.js"></script>

    <?php require 'utils/db_connection.php' ?>
    <?php require 'utils/email.php' ?>
</head>

<body>
    <?php require 'templates/navbar.php'?>
    <?php include 'templates/modal.php' ?>

    <div id="container_center">
        <div class="container">
             <div class="topics"> Registration </div>
            <form class="general_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <!-- PayPal Vars -->
                <input type="hidden" name="cmd"           value="_xclick">
                <input type="hidden" name="business"      value="costarica.isr@gmail.com">
                <input type="hidden" name="item_name"     value="Know-Costa Rica #9"> 
                <input type="hidden" name="item_number"   value="#9">
                <input type="hidden" name="amount"        value="20.00">
                <input type="hidden" name="no_shipping"   value="2"> <!-- to check 2- must enter -->
                <input type="hidden" name="currency_code" value="ILS">
                <input type="hidden" name="lc"            value="IL">
                <input type="hidden" name="bn"            value="Costa-RicaIsrael_BuyNow_WPS_IL">
                <input type="hidden" name="charset"       value="utf-8">

                <fieldset><legend>Personal data:</legend>

                    <label for="fname">First name</label>
                    <input class="form_field" type="text" id="fname" name="first_name" autofocus="" required><br>

                    <label for="lname">Last name</label>
                    <input class="form_field" type="text" id="lname" name="last_name" required><br>

                    <label for="email">Email</label>
                    <input class="form_field" type="email" id="email" name="email" required><br>

                    <label for="mobile">Mobile number</label>
                    <input class="form_field" type="tel" id="mobile" name="night_phone_b" 
                        required pattern="[05]{2}[0|2-9][0-9]{7}" title="Enter a vaild Israeli mobile number"><br><br>

                    <label>Gender</label>
                    <input type="hidden" name="on6" value="Gender">
                    <label class="gender" for="male">Male</label>
                    <input type="radio" id="gender" name="os6" value="male" required>
                    <label class="gender" for="female">Female</label>
                    <input type="radio" id="gender" name="os6" value="female" required><br>

                    <label for="bDate">Date of birth</label>
                    <input type="hidden" name="on0" value="Birth Date">
                    <input class="form_field" type="date" id="bDate" name="os0" min="1920-01-02" onchange="validateDate()" required><br>

                    <!--<label for="address">Address</label>
                    <input class="form_field" type="text" id="address" name="address1" required><br> -->

                </fieldset>
                <fieldset><legend>Student data:</legend>

                    <label for="institution">Institution</label>
                    <input type="hidden" name="on1" value="Institute">
                    <select class="form_field" id="institution" name="os1" value="Institute" required>
                            <option disabled selected value="">Please select..</option>
                            <option value="university">University</option>
                            <option value="college">College</option>
                    </select><br>

                    <label for="institute_id">Institute name</label>
                    <input type="hidden" name="on2" value="Institute Name">
                    <input class="form_field" type="text" id="institute_id" name="os2" required><br>

                    <label for="faculty">Faculty</label>
                    <input type="hidden" name="on3" value="Faculty Name">
                    <input class="form_field" list="faculty_list" id="faculty" name="os3" required>
                    <datalist id="faculty_list">
                        <option value="Natural Sciences">
                        <option value="Engineering Science">
                        <option value="Humanities and Social Sciences">
                        <option value="Health Sciences">
                        <option value="Education">
                        <option value="Art">
                    </datalist><br>

                    <label for="degree">Degree</label>
                    <input type="hidden" name="on4" value="Degree">
                    <input class="form_field" list="degree_list" id="degree" name="os4" required>
                    <datalist id="degree_list">
                        <option disabled selected value="please select">Please select..</option>
                        <option value="Bachelor"></option>
                        <option value="Master"></option>
                        <option value="PhD"></option>
                    </datalist><br>

                    <label for="year_number">Year number</label>
                    <input type="hidden" name="on5" value="Degree">
                    <input class="form_field" type="number" id="year_number" name="os5" min="1" max="7" name="custom" required><br>

                </fieldset>

                <input type="hidden" name="cn" value="Add special instructions to the seller:">
                <input type="hidden" name="no_note" value="0">

                <!--<div id="formbuttons">
                    <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Submit</button>
                    <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
                </div> -->
                
                <div id="formbuttons">
                    <input id="paypal" type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_checkout_pp_142x27.png"  name="submit" alt="PayPal - הדרך הקלה והבטוחה לשלם באינטרנט!"> <br>
                    <span id="cost">Cost: 20 &#8362</span>
                </div>

            </form>
            <br><hr><br>

            <div class="topics"> Know The Winners </div>

            <?php

                $con = makeConnection();
                $row_count = 0;

                $query = "SELECT * FROM winners_en
                          ORDER BY contest_num DESC , place ASC";
                
                if(!$result = prepareAndExecuteQuery($con,$query))
                    echo 'error reading from database... please contact admin!';

                foreach($result as $row) {
                    $new_row = array(
                        "contest_num"       => $row[0],
                        "id"                => $row[1],
                        "name"              => $row[2],
                        "subject"           => $row[3],
                        "institute"         => $row[4],
                        "number_of_pics"    => $row[5],
                        "place"             => $row[6],
                        "pic_path"          => $row[7]);

                    if ($row_count == 0) {
                        echo '<br><h2 align="center">' . (2005 + $new_row["contest_num"]) .'
                        Contest Winneres - #' . $new_row["contest_num"].'</h3>

                        <table class="winnersTable" id="winners_'.$new_row["contest_num"].'">
                                <script> eventsHeader(); </script>';
                    }

                    echo '<tr>
                        <td> ' . ($new_row["place"] == 1 ? '1st' : '2nd') . '</td>
                        <td> <img id="myPic" src=./img/winners/' .
                        $new_row["contest_num"] . '/' . $new_row["pic_path"] . ' /> </td>
                            <td> ' . $new_row["name"] . ' </td>
                            <td> ' . $new_row["subject"] . ' </td>
                            <td> ' . $new_row["institute"] . ' </td>
                        </tr>';

                    if ($row_count == 1) {
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
                        $row_count = 0;

                    } else if ($row_count == 0) {
                        $row_count = 1;
                    }
                }

                if ($row_count == 1) {
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
                    $row_count = 0;
                }
            ?>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
