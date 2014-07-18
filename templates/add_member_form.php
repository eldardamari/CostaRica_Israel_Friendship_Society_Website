<form enctype="multipart/form-data" class="general_form" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">

    <fieldset>
        <legend>Personal data:</legend>

        <label for="fname">Member name</label>
        <input class="form_field" type="text" id="name" name="full_name" autofocus=""
               required pattern="[a-z|A-Z| ]*" title="English Letters Only"><br><br>

        <label for="email">Email</label>
        <input class="form_field" type="email" id="email" name="email" required><br><br>

        <label for="position">Position</label>
        <input class="form_field" type="text" id="position" name="position"
               required pattern="[a-z|A-Z| ]*" title="English Letters Only"><br><br>

        <label for="mobile">Mobile number</label>
        <input class="form_field" type="tel" id="mobile" name="mobile"
               required pattern="[05]{2}[0|2-9][0-9]{7}" title="Enter a vaild Israeli mobile number 05********"><br><br>

        <label for="profile_pic">Profile picture</label>
        <input type="file" name="profile_pic" required><br><br>
    </fieldset>

    <fieldset><legend>About member:</legend>

        <label for="member_title">Member title</label>
        <textarea name="title" class="form_field form_field_medium" style="resize: none;"
                  rows="5" maxlength="100" required=""></textarea> <br>

        <label for="about_me">About me</label>
        <textarea name="about_me" class="form_field form_field_medium" style="resize: none;"
                  rows="20" maxlength="10000" required=""></textarea> <br>

    </fieldset>

    <div id="formbuttons">
        <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Save</button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div>

</form>
