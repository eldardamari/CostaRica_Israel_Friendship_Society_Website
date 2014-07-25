<form enctype="multipart/form-data" class="general_form" id="winner_form_edit" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">

    <fieldset>
        <legend>Contest Details:</legend>
        
        <label for="year_number">Year</label>
        <select class="form_field" id="year" name="year" required autofocus="">
            <option value="Select Year.." disabled selected value="">Select Year..</option>
            <?php 
                $contests_numbers = get_contests_numbers();
                $year_selected = 0;
                if(isset($_REQUEST['year_pic']))
                    $year_selected = (int)$_REQUEST['year_pic'];
                if(isset($_REQUEST['year']))
                    $year_selected = (int)$_REQUEST['year'];
                foreach($contests_numbers as $i) {
                    echo '<option value='.($edit_mode && $year_selected == (2005+$i) ?
                        '"'.(2005+$i).'" selected ' : (2005+$i)).' >'.(2005+$i).' - #'.$i.'</option>';
                }
            ?>
        </select><br><br>


<?php

        $set_place = 0;
        if(isset($_REQUEST['place_pic']))
            $set_place = (int)$_REQUEST['place_pic'];
        if(isset($_REQUEST['place']))
            $set_place = (int)$_REQUEST['place'];

        echo '<label>Place</label>
        <label class="gender" for="male">1st</label>
        <input type="radio" id=radio_first class="place" name="place" value="1" ';

        echo ($edit_mode && $set_place == 1 ? "checked" : "").' >
        <label class="gender" for="female">2nd</label>
        <input type="radio" class="place" name="place" value="2" 
        '.($edit_mode && $set_place == 2 ? " checked" : "") .'> <br>
    </fieldset>';
?>

    <fieldset>
        <legend>Winner Data:</legend>

        <label for="fname">Name</label>
        <input class="form_field" type="text" id="name" name="full_name"
                pattern="[a-z|A-Z| ]*" title="English Letters Only" required><br><br>

        <label for="email">Email</label>
        <input class="form_field" type="email" id="email" name="email" required><br><br>

        <label for="mobile">Mobile number</label>
        <input class="form_field" type="tel" id="mobile" name="mobile"
                required pattern="[05]{2}[0|2-9][0-9]{7}" title="Enter a vaild Israeli mobile number 05********"><br><br>
        
        <label for="institute_id">Institution name</label>
        <input class="form_field form_field_short" type="text" id="institute_id" name="institute"
                required pattern="[a-z|A-Z| ]*" title="English Letters Only"><br><br>
        
        <label for="institute_id">Field of Study</label>
        <input type="hidden" name="subject">
        <input class="form_field form_field_short" type="text" id="subject" name="subject" 
                required pattern="[a-z|A-Z| ]*" title="English Letters Only"><br><br>

        <label for="profile_pic">Profile picture</label>
<div class="div_files">
<label class="btn_icon btn_profile">
       <span > <input type="file" class="file" name="profile_pic" accept="image/*" ></span>
</label>
<span class="files_selected" id="file_profile"> </span>
</div>
    </fieldset>
    
    <fieldset id="winner_pics">
        <legend>Edit Winner Pictures:</legend>
    <?php require 'templates/viewer.php' ?> <br>
        <label for="pictures">Add More Pictures</label>
<div class="div_files">
<label class="btn_icon btn_pictures">
        <span><input type="file" class="btn_icon file" id="pictures" name="pictures[]" accept="image/*" multiple> </span>
</label>
<span class="files_selected" id="files_multi"></span>
</div>
<br>

    </fieldset>

        <input type="hidden" name="edit_winner_request" value="true">
    <div id="formbuttons">
        <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Save</button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div>

</form>

<form class="general_form" id="deletePhoto" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>" >
    <input type="hidden" name="edit_winner_pic_request" value="true">
    <input type="hidden" id="year_pic" name="year_pic">
    <input type="hidden" id="place_pic" name="place_pic">
</form>
