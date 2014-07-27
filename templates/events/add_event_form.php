<form enctype="multipart/form-data" class="general_form" id="add<?php echo $eventType ?>" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">

    <fieldset>
        <legend><?php echo $eventType ?> Details:</legend>
        
        <label for="date">Date</label>
        <input type="date" name="date" id="date" class="form_field"
               value="<?php echo date('Y-m-d'); ?>"  min="<?php echo date('Y-m-d'); ?>"
               required autofocus="" />
        <br><br>

        <label for="eventName"><?php echo $eventType ?>'s Name</label>
        <input class="form_field form_field_medium" type="text" id="eventName" name="eventName"
               pattern="[a-z|A-Z| ]*" title="English Letters Only" required>
        <br><br>

        <label for="description">Description</label>
        <textarea name="description" id="description" class="form_field form_field_medium" style="resize: none;"
                  rows="5" maxlength="100" required=""></textarea>
        <br><br>

        <label for="text">Text</label>
        <textarea id="text" name="text" class="form_field form_field_medium" style="resize: none;"
                  rows="20" maxlength="10000" required=""></textarea>
    </fieldset>
    
    <fieldset>
        <legend><?php echo $eventType ?> pictures:</legend>
        <label for="pictures">Select Multiple Pictures</label>
        <input type="file" class="file" name="pictures[]" accept="image/*" multiple><br><br>
    </fieldset>

    <div id="formbuttons">
        <button class="btn_default" type="submit" name="add">
            <span class="btn_icon icon_add"></span> Add
        </button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div>

</form>