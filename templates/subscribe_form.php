<form class="general_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
    <fieldset>
        <legend>Personal data:</legend>

        <label for="first_name">First name</label>
        <input name="first_name" class="form_field form_field_short" type="text" id="first_name" autofocus="" required><br>

        <label for="last_name">Last name</label>
        <input name="last_name" class="form_field form_field_short" type="text" id="last_name" required><br>

        <label for="email">Email</label>
        <input name="email" class="form_field form_field_short" type="email" id="email" required><br>

        <label for="bulletin">Bulletin</label>
        <input name="bulletin" type="checkbox" id="bulletin"><br>

        <label for="newsletter">Newsletter</label>
        <input name="newsletter" type="checkbox" id="newsletter"><br>

    </fieldset>
    <div id="formbuttons">
        <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Submit</button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div>

</form>