<form enctype="multipart/form-data"
      class="general_form" id="editEventForm"
      method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <input type="hidden" id="eventType" name="eventType" value="<?php echo $eventType ?>">
    <fieldset>
        <legend><?php echo $eventType ?> Details:</legend>

        <label for="eventId"><?php echo $eventType ?>'s Id</label>
        <select class="form_field form_field_medium" id="eventId" name="eventId" required autofocus="">
            <option value="" disabled selected value="">Select <?php echo $eventType ?>..</option>
            <?php
                $events = getEventsName(strtolower($eventType).'s_en');
                foreach($events as $event) {
                    echo '<option value="'.$event['id'].'">'.$event['name'].'</option>';
                }
            ?>
        </select>

        <button name="deleteEvent" id="deleteEvent" hidden="" type="submit" class="btn_default">
            <span class="btn_icon icon_delete"></span> Remove
        </button>
        <br><br>

        <label for="editEventName"><?php echo $eventType ?>'s Name</label>
        <input class="form_field form_field_medium" type="text" id="editEventName" name="eventName"
               pattern="[a-z|A-Z| ]*" title="English Letters Only" required autofocus="">
        <br><br>

        <label for="editDate">Date</label>
        <input type="date" name="date" id="editDate" class="form_field"
               min="1990-01-01" required />
        <br><br>

        <label for="editDescription">Description</label>
        <textarea name="description" id="editDescription"
                  class="form_field form_field_medium"
                  style="resize: none;" rows="5" maxlength="100"
                  required=""></textarea>
        <br><br>

        <label for="editText">Text</label>
        <textarea id="editText" name="text"
                  class="form_field form_field_medium"
                  style="resize: none;" rows="20" maxlength="10000"
                  required=""></textarea>
    </fieldset>

    <fieldset id="eventPictures">
        <legend>Edit <?php echo $eventType ?> Pictures:</legend>
        <?php require 'templates/viewer.php' ?> <br>
        <label for="pictures">Add More Pictures</label>

        <div class="div_files">
            <label class="btn_icon btn_pictures">
                    <span><input type="file" class="btn_icon file" id="pictures" name="pictures[]" accept="image/*" multiple> </span>
            </label>
            <span class="files_selected" id="files_multi"></span>
        </div>
    </fieldset>

    <input type="hidden" name="editEvent" value="true"/>
    <div id="formbuttons">
        <button name="updateEvent" class="btn_default" type="submit">
            <span class="btn_icon icon_accept"></span> Save
        </button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div>

</form>

<form id="deletePhoto" class="general_form"
      method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <button type="submit" class="btn_large" id="action"/>
</form>
