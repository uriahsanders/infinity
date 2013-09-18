<body bgcolor="#2d3035">
<?php
$image = "valfr.png";
$c = array(4,0,4);
$img = imagecreatefrompng($image);
list($width, $height) = getimagesize($image);
    echo "<center><div style=\"line-height:0em;word-spacing:0px;position:relative;margin-left:auto;margin-right:auto;border: 0px solid #000;padding:0px;
    \">";
    for ($y = 0; $y < $height; $y++) {
        for ($x = 0; $x < $width; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $rgb = imagecolorsforindex($img, $rgb);
            echo "<div style=\"font-size:5px;padding:0px;position:relative;display:inline-block;color: rgba(".$rgb['red'].",".$rgb['green'].",".$rgb['blue'].",1)\">#&nbsp;</div>";
        }
        echo "\n<br />\n";
    }
?>
</div>