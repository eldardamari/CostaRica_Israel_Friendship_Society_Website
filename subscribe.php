<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">
    <link rel="stylesheet" href="/costaRicaIsrael/css/form.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>

<body>
    <script src="/costaRicaIsrael/js/nav_bar.js"></script>

    <div id="container_center">
        <div class="container">
            <form class="general_form" method="post" action="subscribe.php">
                <fieldset>
                    <legend>Personal data:</legend>

                    <label for="first_name">First name</label>
                    <input class="form_field" type="text" id="first_name" autofocus="" required><br>

                    <label for="last_name">Last name</label>
                    <input class="form_field" type="text" id="last_name" required><br>

                    <label for="email">Email</label>
                    <input class="form_field" type="email" id="email" required><br>

                    <label for="bulletin">Bulletin</label>
                    <input class="" type="checkbox" id="bulletin"><br>

                    <label for="newsletter">Newsletter</label>
                    <input class="" type="checkbox" id="newsletter"><br>

                </fieldset>
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
