<form enctype="multipart/form-data" class="general_form" id="subscriptions_form_add" 
        method="post" action="<?php echo $_SERVER["PHP_SELF"]?>">

    <fieldset>
        <legend>Publish Details:</legend>
        
        <label for="year_number">Year</label>
        <select class="form_field" id="year" name="year" required autofocus="">
            <option disabled selected value="">Select Year..</option>
            <?php 
                for($i=0 ; $i < 20 ; $i++)
                    echo '<option value='.(2006+$i).'>'.(2006+$i).'</option>';
            ?>
        </select><br><br>
        
        <label for="month_number">Month</label>
        <select class="form_field" id="month" name="month" required autofocus="">
            <option disabled selected value="">Select Month..</option>
            <?php 
                for($i=1 ; $i < 13 ; $i++)
                    echo '<option value='.$i.'>'.get_month($i).'</option>';
            ?>
        </select><br><br>

        <label for="catalog">Catalog Number</label>
        <input class="form_field" type="number" id="catalog" name="catalog"
                pattern="[0-9]*" title="Numbers Only" step="any" min="1" required><br><br>

        <label>Add</label>
        <label class="gender" for="male">Newsletter</label>
        <input type="radio"  id="gender" name="subscription" value="newsletter" required>
        <label class="gender" for="female">Bulletin</label>
        <input type="radio" id="gender" name="subscription" value="bulletin" required><br>
    </fieldset>

    <fieldset>
        <legend>Upload Document: (*.doc / *.docx / *.pdf) </legend><br>


        <label for="select_document">Select Document</label>
        <input type="file" class="file" name="uploaded_document" 
                accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document, 
                application/msword, application/pdf" required>
    </fieldset>

        <input type="hidden" name="add_subscription_request" value="true">

        <div id="formbuttons">
            <button class="btn_default" type="submit" name="add">
                <span class="btn_icon icon_add"></span> Add</button>
            <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
        </div>
</form>
