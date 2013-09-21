<?php
$image = "chalx.png";
$img = imagecreatefrompng($image);
list($width, $height) = getimagesize($image);
$rgb = imagecolorat($img, 0, 0);
$frgb = imagecolorsforindex($img, $rgb);
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($img, $x, $y);
            $rgb = imagecolorsforindex($img, $rgb);
            if ($rgb !== $frgb) {
                echo "x: $x <br />y: $y <br />";
                die();
            }
            $frgb = $rgb;
        }
    }
?>