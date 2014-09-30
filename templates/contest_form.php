<form id="paypal_form" class="general_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <!-- PayPal Vars -->
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="A9TGAAGBZ5WEU">
<input type="hidden" name="active_pay">

	 <div id="formbuttons">
		<span id="cost">Registration is over, see you next year :)</span>
	</div>

    <fieldset><legend>Personal data:</legend>

        <label for="fname">First name</label>
        <input class="form_field" type="text" id="fname" name="first_name" autofocus="" required><br>

        <label for="lname">Last name</label>
        <input class="form_field" type="text" id="lname" name="last_name" required><br>

        <label for="email">Email</label>
        <input class="form_field" type="email" id="email" name="email" required><br>

        <label for="mobile">Mobile number</label>
        <input class="form_field" type="tel" id="mobile" name="night_phone_b"
               required pattern="[05]{2}[0|2-9][0-9]{7}" title="Enter a vaild Israeli mobile number"><br><br>

        <label>Gender</label>
        <input type="hidden" name="on6" value="Gender">
        <label class="gender" for="male">Male</label>
        <input type="radio" id="gender" name="os6" value="male" required>
        <label class="gender" for="female">Female</label>
        <input type="radio" id="gender" name="os6" value="female" required><br>

        <label for="bDate">Date of birth</label>
        <input type="hidden" name="on0" value="Birth Date">
        <input class="form_field" type="date" id="bDate" name="os0" min="1920-01-02" onchange="validateDate()" required><br> 

        <!--<label for="address">Address</label>
        <input class="form_field" type="text" id="address" name="address1" required><br> -->

    </fieldset>
    <fieldset><legend>Student data:</legend>

        <label for="institution">Institution</label>
        <input type="hidden" name="on1" value="Institute">
        <select class="form_field" id="institution" name="os1" value="Institute" required>
            <option disabled selected value="">Please select..</option>
            <option value="university">University</option>
            <option value="college">College</option>
        </select><br>

        <label for="institute_id">Institute name</label>
        <input type="hidden" name="on2" value="Institute Name">
        <input class="form_field" type="text" id="institute_id" name="os2" required><br>

        <label for="faculty">Faculty</label>
        <input type="hidden" name="on3" value="Faculty Name">
        <input class="form_field" list="faculty_list" id="faculty" name="os3" required>
        <datalist id="faculty_list">
            <option value="Natural Sciences">
            <option value="Engineering Science">
            <option value="Humanities and Social Sciences">
            <option value="Health Sciences">
            <option value="Education">
            <option value="Art">
        </datalist><br>

        <label for="degree">Degree</label>
        <input type="hidden" name="on4" value="Degree">
        <input class="form_field" list="degree_list" id="degree" name="os4" required>
        <datalist id="degree_list">
            <option disabled selected value="please select">Please select..</option>
            <option value="Bachelor"></option>
            <option value="Master"></option>
            <option value="PhD"></option>
        </datalist><br>

        <label for="year_number">Year number</label>
        <input type="hidden" name="on5" value="Degree">
        <input class="form_field" type="number" id="year_number" name="os5" min="1" max="7" name="custom" required><br>

    </fieldset>

    <input type="hidden" name="cn" value="Add special instructions to the seller:">
    <input type="hidden" name="no_note" value="0">

    <!--<div id="formbuttons">
        <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Submit</button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div> -->

    <div id="formbuttons">
        <img id="paypal" type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_checkout_pp_142x27.png"  name="submit"> <br>
        <span id="cost">Cost: 20 &#8362</span>
    </div>

</form>
