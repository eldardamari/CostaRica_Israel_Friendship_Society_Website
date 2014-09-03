<form class="general_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
    <fieldset>
        <label for="from">From</label>
        <input name="email" type="email" id="from" class="form_field form_field_short" placeholder="Insert Your Email" required="">
        <br><br>

        <label for="contact">To</label>
        <select name="contact" id="contact" class="form_field form_field_short" required="">
            <option value="" disabled>Select Contact</option>
            <?php
            foreach($result as $member) {
                if(isset($_REQUEST['id'])) {
                    $memeber_id = $_REQUEST['id'];
                    if($memeber_id == $member['id']) {
                        echo '<option selected="selected" value="'.$member['id'].'" >'.$member['name'].'</option>"';
                        continue;
                    }
                }
                echo '<option value="'.$member['id'].'" >'.$member['name'].'</option>"';
            }
            ?>
        </select>
        <br><br>

        <label for="subject">Subject</label>
        <input name="subject" type="text" id="subject" class="form_field form_field_medium" placeholder="Enter Subject" required="">
        <br><br>

        <label for="mailContent">Content</label>
        <textarea name="content" id="mailContent" class="form_field form_field_medium" style="resize: none;" rows="15" maxlength="300" required=""></textarea>
    </fieldset>

    <div id="formbuttons">
        <button id="contact_btn" class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Send</button>
    </div>
</form>
