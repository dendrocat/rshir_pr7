<?php
phpinfo();
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "PHP GD library is installed on your web server";
} else {
    echo "PHP GD library is NOT installed on your web server";
}
echo "<br>";
if (function_exists("imagettfbbox")) {
    echo "imagettfbbox exists";
}
else {
    echo "imagettfbbox not exists";
}

?>