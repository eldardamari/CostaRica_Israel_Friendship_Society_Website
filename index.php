<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Costa Rica Israel</title>
    <link rel="stylesheet" href="/costaRicaIsrael/css/main.css">

    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="/costaRicaIsrael/js/events.js"></script>
    <?php require 'utils/db_connection.php' ?>

</head>
<body>
    <?php require 'templates/navbar.php'?>

    <div id="container_center">
        <div class="container text">

            <?php include 'templates/slide_show.php' ?>

            <p lang="en">
                <strong>Costa-Rica Israel Friendship Association</strong>
                <br><br>
                The association was funded in July 30, as a non-profit register organization. 
                Established by a handful jewish pioneers from south & central america countires. 
                Beleiving in the state of Israel and the maintaining relationship with both countires.
                By doing so, communities living in Costa-Rica can have an address for establishing they Israeli
                relations. The association conduct a special yearly program "Know Costa-Rica Contest" an opprotunity
                for students in Israel to explorer Costa-Rica in a unique way.
                <br><br>
            </p>

            <?php include 'utils/home_page.php' ?>

            <br>
            <div class="main_box" id="partners">
                <div class="box_header box_header_large"> Partners </div>
                <div> 
                    <a href="http://mfa.gov.il/MFA/Pages/default.aspx" target="_blank">
                        <img src="./img/partners/imf.jpg" height="118" width="100" ></a>
                    <a href="http://www.rree.go.cr/" target="_blank"> 
                        <img src="./img/partners/crmf.png" height="100" width="200" ></a>
                    <a href="http://embassies.gov.il/san-jose/Pages/default.aspx" target="_blank">
                        <img src="./img/partners/iemb.png" height="50" width="400" ></a>
                    <a href="http://english.tau.ac.il/" target="_blank">
                        <img src="./img/partners/tau.png" height="54" width="256" ></a>
                        <a href="http://en.allalouf.com/" target="_blank">
                        <img src="./img/partners/allalouf.png" height="74" width="277" ></a>
                    <a href="http://www.proimagen.cr/en" target="_blank">
                        <img src="./img/partners/proimagen.png" height="107" width="312" ></a>
                        <a href="http://www.google.co.il/" target="_blank">
                            <img src="./img/partners/alpha_club.gif" height="90" width="180" ></a>
                </div>
            </div>
        </div>
    </div>

    <?php require 'templates/footer.php' ?>

</body>
</html>
