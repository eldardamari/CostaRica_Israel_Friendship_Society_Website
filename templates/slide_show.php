    <link rel="stylesheet" href="/costaRicaIsrael/css/slide_show.css">
    <script src="/costaRicaIsrael/js/slide_show.js"></script>

    <div id="slideshow">
        <div class="active">
            <a href="#"><img  src="img/slide_show/first/Tree Frog.jpg"></a>
            <p class="caption text_center">Tree Frog</p>
        </div>

        <?php
            include 'utils/resize-class.php';
            $images = glob("img/slide_show/*.*");

            foreach($images as $image) {
                $splitPath = explode("/",$image);

                $resizeObj = new resize($image);
                $resizeObj -> resizeImage(1024, 400, 'crop');
                $resizeObj -> saveImage($image, 100);

                $caption = explode(".",end($splitPath));
                $caption = $caption[0];

                echo '<div>'.
                        '<a href="#"><img src="'.$image.'"></a>'.
                        '<p class="caption text_center">'.$caption.'</p>'.
                     '</div>';
            }
        ?>
    </div>