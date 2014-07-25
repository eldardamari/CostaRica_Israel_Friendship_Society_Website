<form enctype="multipart/form-data" class="general_form" id="winner_form_add" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">

    <fieldset>
        <legend>Contest Details:</legend>
        
        <label for="year_number">Year</label>
        <select class="form_field" id="year" name="year" required autofocus="">
            <option disabled selected value="">Select Year..</option>
            <?php 
                for($i=0 ; $i < 10 ; $i++)
                    echo '<option value='.(2014+$i).'>'.(2014+$i).'</option>';
            ?>
        </select><br><br>

        <label>Place</label>
        <label class="gender" for="male">1st</label>
        <input type="radio"  id="gender" name="place" value="1" required>
        <label class="gender" for="female">2nd</label>
        <input type="radio" id="gender" name="place" value="2" required><br>
    </fieldset>

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
               <span > <input type="file" class="file" name="profile_pic" accept="image/*" required></span>
        </label>
        <span class="files_selected" id="file_profile"> </span>
    </div>
    </fieldset>

    <fieldset>
        <legend>Winner Pictures:</legend>

        <label for="pictures">Select Multiple Pictures</label>
    <div class="div_files">
        <label class="btn_icon btn_pictures">
                <span><input type="file" class="btn_icon file" id="pictures" name="pictures[]" accept="image/*" multiple> </span>
        </label>
        <span class="files_selected" id="files_multi"></span>
    </div>
    </fieldset>

        <input type="hidden" name="add_winner_request" value="true">

        <div id="formbuttons">
            <button class="btn_default" type="submit" name="add">
                <span class="btn_icon icon_add"></span> Add</button>
            <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
        </div>
</form>


