<?php
    include_once 'utils/control_panel_functions.php';
    securedSessionStart();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">

    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/login.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

</head>
<body>
    <?php include 'templates/navbarpannel.php' ?>

    <div id="container_center">
        <div class="container text">

            <p class="text">You are not authorized to access this page, please login.</p>

            <?php
                if(isset($_GET['error']))
                    echo '<p class="text form_error">Incorrect username or password</p>';
            ?>

            <form name="login_form" class="general_form" method="post" action="utils/process_login.php">
                <fieldset>
                    <legend>Login:</legend>
                    <br>
                    <label for="username">Username</label>
                    <input class="form_field form_field_short" type="text" name="username" id="username" autofocus="" required="" />
                    <br><br>
                    <label for="password">Password</label>
                    <input class="form_field form_field_short" type="password" name="password" id="password" required="" />
                    <br><br>
                </fieldset>

                <div id="formbuttons">
                    <button class="btn_default" type="submit" onclick="submitLogin(this.form, this.form.password);">
                        <span class="btn_icon icon_login"></span> Login
                    </button>
                </div>
            </form>

        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>