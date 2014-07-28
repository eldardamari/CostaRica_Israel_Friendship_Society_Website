    <link rel="stylesheet" href="/costaRicaIsrael/css/slide_show.css">
    <script src="/costaRicaIsrael/js/slide_show.js"></script>

    <div id="slideshow">
        <div class="active">
            <a href="#"><img  src="img/slide_show/map/map-costa-rica.gif"></a>
            <p class="caption text_center">Map Of Costa Rica</p>
        </div>

        <?php
            $images = glob("img/slide_show/*.*");

            foreach($images as $image) {
                $splitFilename = explode("/",$image);
                $caption = explode(".",end($splitFilename));
                $caption = $caption[0];

                echo '<div>'.
                        '<a href="#"><img src="'.$image.'"></a>'.
                        '<p class="caption text_center">'.$caption.'</p>'.
                     '</div>';
            }
        ?>
    </div>