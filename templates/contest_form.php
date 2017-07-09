<form id="paypal_form" class="general_form" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <!-- PayPal Vars -->
<input type="hidden" name="active_pay">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="charset" value="utf-8">
<input type="hidden" name="hosted_button_id" value="UVK24TG5UFRWG">

	 <div id="formbuttons">
		<span id="cost">"Know Costa Rica Contest #12 Registration is Now OPEN!</span><br>
		<span id="">(available until August 10, 2017 12:00pm)</span><br>
		<span id="">Contact us via our <b><a href="https://www.facebook.com/israelcostaricafriendship" 
						  style="color:rgb(59,89,152);">Facebook page!</a></b></span><br>
		<!-- <span id="" onmousedown="contact_member('0');" onmouseover="" style="cursor: pointer;">
					or <u>email us!</u> (we prefer facebook)</span> -->
	</div>

    <fieldset><legend>Personal data:</legend>

        <label for="fname">First name</label>
        <input type="hidden" name="on0" value="First name">
        <input class="form_field" type="text" id="fname" name="os0" autofocus="" required><br>

        <label for="lname">Last name</label>
        <input type="hidden" name="on1" value="Last name">
        <input class="form_field" type="text" id="lname" name="os1" required><br>

        <label for="email">Email</label>
        <input type="hidden" name="on3" value="Email">
        <input class="form_field" type="email" id="email" name="os3" required><br>

        <label for="mobile">Mobile number</label>
        <input type="hidden" name="on4" value="Mobile:">
        <input class="form_field" type="tel" id="mobile" name="os4"
               required pattern="[05]{2}[0|2-9][0-9]{7}" title="Enter a vaild Israeli mobile number"><br><br>

        <label>Gender</label>
        <input type="hidden" name="on5" value="Gender">
        <label class="gender" for="male">Male</label>
        <input type="radio" id="gender" name="os5" value="male" required>
        <label class="gender" for="female">Female</label>
        <input type="radio" id="gender" name="os5" value="female" required><br>

        <label for="bDate">Date of birth</label>
        <input type="hidden" name="on6" value="Birth Date">
        <input class="form_field" type="date" id="bDate" name="os6" min="1920-01-02" onchange="validateDate()" required><br> 

        <!--<label for="address">Address</label>
        <input class="form_field" type="text" id="address" name="address1" required><br> -->

    </fieldset>
    <fieldset><legend>Student data:</legend>

        <label for="institution">Institution</label>
        <input type="hidden" name="on7" value="Institute">
        <select class="form_field" id="institution" name="os7" value="Institute" required>
            <option disabled selected value="">Please select..</option>
            <option value="university">University</option>
            <option value="college">College</option>
        </select><br>

        <label for="institute_id">Institute name</label>
        <input type="hidden" name="on8" value="Institute Name">
        <input class="form_field" type="text" id="institute_id" name="os8" required><br>
            
        <label for="institute_id">Field of study</label>
        <input type="hidden" name="on9" value="Field of study">
        <input class="form_field" type="text" id="institute_id" name="os9" required><br>

        <label for="faculty">Faculty</label>
        <input type="hidden" name="on10" value="Faculty Name">
        <input class="form_field" list="faculty_list" id="faculty" name="os10" required>
        <datalist id="faculty_list">
            <option value="Natural Sciences">
            <option value="Engineering Science">
            <option value="Humanities and Social Sciences">
            <option value="Health Sciences">
            <option value="Education">
            <option value="Art">
            <option value="Other">
        </datalist><br>

        <label for="degree">Degree</label>
        <input type="hidden" name="on11" value="Degree">
        <input class="form_field" list="degree_list" id="degree" name="os11" required>
        <datalist id="degree_list">
            <option disabled selected value="please select">Please select..</option>
            <option value="Bachelor"></option>
            <option value="Master"></option>
            <option value="PhD"></option>
            <option value="Other"></option>
        </datalist><br>

        <label for="year_number">Year number</label>
        <input type="hidden" name="on12" value="Degree">
        <input class="form_field" type="number" id="year_number" name="os12" min="1" max="7" name="custom" required><br>

    </fieldset>

    <input type="hidden" name="cn" value="Add special instructions to the seller:">
    <input type="hidden" name="no_note" value="0">

    <!--<div id="formbuttons">
        <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Submit</button>
        <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
    </div> -->

    <div id="formbuttons">
        <input id="paypal" type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_checkout_pp_142x27.png"  name="submit"> <br>
        <span id="cost">Cost: 20 &#8362</span>
    </div>

</form>

