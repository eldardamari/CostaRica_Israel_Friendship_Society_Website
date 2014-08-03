<form enctype="multipart/form-data" class="general_form" id="subscription_form_edit" method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">

    <fieldset>
        <legend>Publish Details:</legend>
        
        <label>Select Publish</label>
        <label class="gender" for="male">Newsletter</label>
        <input type="radio"  class="type" id="gender" name="subscription" value="newsletter" required>
        <label class="gender" for="female">Bulletin</label>
        <input type="radio" class="type" id="gender" name="subscription" value="bulletin" required><br>

    </fieldset>

    <br><fieldset id="winner_pics">
        <legend>Select Document:</legend>

    <?php require 'templates/viewer.php' ?> <br>

<br>

    </fieldset>

        <input type="hidden" name="edit_subscriptions_request" value="true">
    <div id="formbuttons">
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div>
</form>
