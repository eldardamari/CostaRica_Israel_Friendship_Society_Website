<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
</head>

<body>
    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

<div id="container_center">
<div class="container">
    <form class="general_form" method="post" action="form.php">
        <fieldset><legend>Personal data:</legend>

            <label for="fname">First name</label>
            <input class="form_field" type="text" name="fname" required><br>

            <label for="lname">Last name</label>
            <input class="form_field" type="text" name="lname" required><br>

            <label for="email">Email</label>
            <input class="form_field" type="email" name="email" required><br>

            <label for="mobile">Mobile number</label>
            <input class="form_field" type="tel" required pattern="[05]{2}[0-9]{8}" title="Enter a vaild Israeli mobile number"><br><br>

            <label for="gender">Gender</label>
            Male        <input type="radio" name="gender" value="male" required>
            Female      <input type="radio" name="gender" value="female" required><br>

            <label for="Bdate">Date of birth</label>
            <input class="form_field" type="date" name="Bdate" required><br>

            <label for="address">Address</label>
            <input class="form_field" type="text" name="address" required><br>

        </fieldset>
        <fieldset><legend>Student data:</legend>

            <label for="Institution">Institution</label>
            <select class="form_field" name="Institution[]" required>
                    <option disabled selected value="please select.." >Please select..</option>
                    <option value="university">University</option>
                    <option value="college">College</option>
            </select><br>

            <label for="institute">Institute name</label>
            <input class="form_field" type="text" name="fclty_name" required><br>

            <label for="faculty">Faculty</label>
            <input class="form_field" list="fclty" name="faculty" required>
            <datalist id="fclty">
                <option value="Natural Sciences">
                <option value="Engineering Science">
                <option value="Humanities and Social Sciences">
                <option value="Health Sciences">
                <option value="Education">
                <option value="Art">
            </datalist><br>

            <label for="degree">Degree</label>
            <input class="form_field" list="degree" name="degree[]" required>
            <datalist id="degree">
                <option disabled selected value="please select">Please select..</option>
                <option value="Bachelor"></option>
                <option value="Master"></option>
                <option value="PhD"></option>
            </datalist><br>

            <label for="year">Year number</label>
            <input class="form_field" type="number" name="years" min="1" max="7" required><br>
        </fieldset>
        <br>
        <div id="formbuttons">
            <input class="form_field" type="submit" value="Submit Form">
            <input class="form_field" type="reset" value="Reset Form"><br>
        </div>
    </form>
</div> 
</div>
</body>
</html>

