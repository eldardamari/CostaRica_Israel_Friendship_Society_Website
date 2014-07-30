<?php
    include 'files.php';

    Class resize
    {
        private $image;
        private $width;
        private $height;
        private $imageResized;

        public function __construct($fileName) {
            $this->image = $this->openImage($fileName);

            $this->width  = imagesx($this->image);
            $this->height = imagesy($this->image);
        }

        private function openImage($file) {
            $extension = getFileExtension($file);

            switch($extension)
            {
                case '.jpg':
                case '.jpeg':
                    $image = @imagecreatefromjpeg($file);
                    break;
                case '.gif':
                    $image = @imagecreatefromgif($file);
                    break;
                case '.png':
                    $image = @imagecreatefrompng($file);
                    break;
                default:
                    $image = false;
                    break;
            }
            return $image;
        }

        public function resizeImage($newWidth, $newHeight, $option="auto") {

            $optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));

            $optimalWidth  = $optionArray['optimalWidth'];
            $optimalHeight = $optionArray['optimalHeight'];

            if($optimalWidth !== $this->width && $optimalHeight !== $this->height ) {
                var_dump($optionArray);
                $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
                imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);

                if ($option == 'crop') {
                    $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
                }
            } else {
                $this->imageResized = null;
            }
        }

        private function getDimensions($newWidth, $newHeight, $option) {

            switch ($option)
            {
                case 'exact':
                    $optimalWidth = $newWidth;
                    $optimalHeight= $newHeight;
                    break;
                case 'portrait':
                    $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                    $optimalHeight= $newHeight;
                    break;
                case 'landscape':
                    $optimalWidth = $newWidth;
                    $optimalHeight= $this->getSizeByFixedWidth($newWidth);
                    break;
                case 'auto':
                    $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
                    $optimalWidth = $optionArray['optimalWidth'];
                    $optimalHeight = $optionArray['optimalHeight'];
                    break;
                case 'crop':
                    $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
                    $optimalWidth = $optionArray['optimalWidth'];
                    $optimalHeight = $optionArray['optimalHeight'];
                    break;
            }

            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }

        private function getSizeByFixedHeight($newHeight) {
            $ratio = $this->width / $this->height;
            $newWidth = $newHeight * $ratio;
            return $newWidth;
        }

        private function getSizeByFixedWidth($newWidth) {
            $ratio = $this->height / $this->width;
            $newHeight = $newWidth * $ratio;
            return $newHeight;
        }

        private function getSizeByAuto($newWidth, $newHeight) {

            // Image to be resized is wider (landscape)
            if ($this->height < $this->width) {
                $optimalWidth = $newWidth;
                $optimalHeight= $this->getSizeByFixedWidth($newWidth);
            }

            // Image to be resized is taller (portrait)
            elseif ($this->height > $this->width) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight= $newHeight;
            }

            // Image to be resizerd is a square
            else {
                if ($newHeight < $newWidth) {
                    $optimalWidth = $newWidth;
                    $optimalHeight= $this->getSizeByFixedWidth($newWidth);
                } else if ($newHeight > $newWidth) {
                    $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                    $optimalHeight= $newHeight;
                } else {
                    $optimalWidth = $newWidth;
                    $optimalHeight= $newHeight;
                }
            }

            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }

        private function getOptimalCrop($newWidth, $newHeight) {

            $heightRatio = $this->height / $newHeight;
            $widthRatio  = $this->width /  $newWidth;

            if ($heightRatio < $widthRatio) {
                $optimalRatio = $heightRatio;
            } else {
                $optimalRatio = $widthRatio;
            }

            $optimalHeight = $this->height / $optimalRatio;
            $optimalWidth  = $this->width  / $optimalRatio;

            return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
        }

        private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight) {
            // Find center
            $cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
            $cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

            $crop = $this->imageResized;
            //imagedestroy($this->imageResized);

            // Now crop from center to exact requested size
            $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
            imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
        }

        public function saveImage($savePath, $imageQuality="100") {

            if($this->imageResized) {

                $extension = getFileExtension($savePath);

                switch($extension)
                {
                    case '.jpg':
                    case '.jpeg':

                        if (imagetypes() & IMG_JPG) {
                            imagejpeg($this->imageResized, $savePath, $imageQuality);
                        }
                        break;

                    case '.gif':

                        if (imagetypes() & IMG_GIF) {
                            imagegif($this->imageResized, $savePath);
                        }
                        break;

                    case '.png':

                        // Scale quality from 0-100 to 0-9
                        $scaleQuality = round(($imageQuality/100) * 9);

                        // Invert quality setting as 0 is best, not 9
                        $invertScaleQuality = 9 - $scaleQuality;

                        if (imagetypes() & IMG_PNG) {
                            imagepng($this->imageResized, $savePath, $invertScaleQuality);
                        }
                        break;

                    default:
                        // No extension - don't save.
                        break;
                }

                imagedestroy($this->imageResized);
            }
        }
    }