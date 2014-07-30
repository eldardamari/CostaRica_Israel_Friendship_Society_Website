<form class="general_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
    <fieldset>

        <label for="email">Email</label>
        <input name="email" class="form_field form_field_short" type="email" id="email" required><br><br>

        <label for="bulletin">Bulletin</label>
        <input name="bulletin" type="checkbox" id="bulletin"><br>

        <label for="newsletter">Newsletter</label>
        <input name="newsletter" type="checkbox" id="newsletter"><br>

    </fieldset>
    <div id="formbuttons">
        <button class="btn_medium" type="submit"><span class="btn_icon icon_delete"></span> Unsubscribe</button>
    </div>

</form>
