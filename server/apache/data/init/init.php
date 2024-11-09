<?php
require_once "/server/data/app/core/consts.php";
require_once "/server/data/app/core/database_sql.php";

require_once "generate_fixtures.php";
require_once "util_graphics.php";
require_once "util_watermark.php";

generate_fixtures();
$dir = "/server/data/";
$folder = "app/graphics/";
if (!is_dir($dir . $folder) || !file_exists($dir . $folder)) {
    mkdir($dir . $folder, 0777, true);
}
$graphics = [
    'line' => [
        'path' => $dir . $folder . 'line.png',
        'name' => 'Линейный график'],
    'bar' => [
        'path' => $dir . $folder . 'bar.png',
        'name' => 'Столбчатая диаграмма'],
    'pie' => [
        'path' => $dir . $folder . 'pie.png',
        'name' => 'Круговая диаграмма']
];
generateGraphics($graphics);
$watermark = $dir . $folder . "water.png";
addWatermarks($graphics, $watermark);

$q = "INSERT INTO graphs (name, path) VALUES ";
foreach ($graphics as $graph) {
    $q .= "('" . $graph['name'] . "', '" . str_replace($dir, "/", $graph['path']) . "'),";
}
$q = substr($q, 0, -1);
DatabaseSQL::query($q);
?>