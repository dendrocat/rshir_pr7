<?php
function addWatermark($file, $water) {
    $image = imagecreatefrompng($file);
    $watermark = imagecreatefrompng($water);

    $imgW = imagesx($image);
    $imgH = imagesy($image);
    $waterW = imagesx($watermark);
    $waterH = imagesy($watermark);

    $x = $imgW - $waterW;
    $y = 0;

    imagecopy($image, $watermark, $x, $y, 0, 0, $waterW, $waterH);

    imagepng($image, $file);
    imagedestroy($image);
    imagedestroy($watermark);
}

function addWatermarks($graphics, $watermark_path) {
    foreach($graphics as $graph) {
        addWatermark($graph['path'], $watermark_path);
    }
}
?>