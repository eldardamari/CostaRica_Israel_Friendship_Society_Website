<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
    <script>

        function validateDate()
        {
            var birthDate = document.getElementById('bDate').value;

            if (Date.parse(birthDate) > Date.now()) {
                document.getElementById('bDate').style.background = "#FAA59E";
            }
            else
                document.getElementById('bDate').style.background = "#ECFFEC";
        }
    </script>
</head>

<body>
    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

    <div id="container_center">
        <div class="container">
            <form class="general_form" method="get" action="form.php">
                <fieldset><legend>Personal data:</legend>

                    <label for="fname">First name</label>
                    <input class="form_field" type="text" id="fname" autofocus="" required><br>

                    <label for="lname">Last name</label>
                    <input class="form_field" type="text" id="lname" required><br>

                    <label for="email">Email</label>
                    <input class="form_field" type="email" id="email" required><br>

                    <label for="mobile">Mobile number</label>
                    <input class="form_field" type="tel" id="mobile" required pattern="[05]{2}[0-9]{8}" title="Enter a vaild Israeli mobile number"><br><br>

                    <label>Gender</label>
                    <label class="gender" for="male">Male</label>
                    <input type="radio" id="male" name="gender" value="male" required>
                    <label class="gender" for="female">Female</label>
                    <input type="radio" id="female" name="gender" value="female" required><br>

                    <label for="bDate">Date of birth</label>
                    <input class="form_field" type="date" id="bDate" min="1920-01-02" onchange="validateDate()" required><br>

                    <label for="address">Address</label>
                    <input class="form_field" type="text" id="address" required><br>

                </fieldset>
                <fieldset><legend>Student data:</legend>

                    <label for="institution">Institution</label>
                    <select class="form_field" id="institution" required>
                            <option disabled selected value="">Please select..</option>
                            <option value="university">University</option>
                            <option value="college">College</option>
                    </select><br>

                    <label for="institute_id">Institute id</label>
                    <input class="form_field" type="text" id="institute_id" required><br>

                    <label for="faculty">Faculty</label>
                    <input class="form_field" list="faculty_list" id="faculty" required>
                    <datalist id="faculty_list">
                        <option value="Natural Sciences">
                        <option value="Engineering Science">
                        <option value="Humanities and Social Sciences">
                        <option value="Health Sciences">
                        <option value="Education">
                        <option value="Art">
                    </datalist><br>

                    <label for="degree">Degree</label>
                    <input class="form_field" list="degree_list" id="degree" required>
                    <datalist id="degree_list">
                        <option disabled selected value="please select">Please select..</option>
                        <option value="Bachelor"></option>
                        <option value="Master"></option>
                        <option value="PhD"></option>
                    </datalist><br>

                    <label for="year_number">Year number</label>
                    <input class="form_field" type="number" id="year_number" min="1" max="7" required><br>
                </fieldset>
                <br>
                <div id="formbuttons">
                    <button class="btn_default" type="submit"><span class="btn_icon icon_accept"></span> Submit</button>
                    <button class="btn_default" type="reset"><span class="btn_icon icon_refresh"></span> Reset</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="/costaRicaIsrael/js/footer.js"></script>

</body>
</html>
