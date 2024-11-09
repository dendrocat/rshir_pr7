<?php
require_once "/server/vendor/autoload.php";


use CpChart\Data;
use CpChart\Image;
use CpChart\Chart\Pie;

function get_columns() {
    $q = "SELECT sum(number) as num, country FROM cities group by country";
    $rows = DatabaseSQL::query($q);

    $countries = [];
    $nums = [];

    foreach($rows as $row) {
        $countries[] = $row['country'];
        $nums[] = $row['num'];
    }

    return [$nums, $countries];
}

function getData() {
    list($nums, $countries) = get_columns();

    $data = new Data();
    $data->AddPoints($nums, "Probe");
    $data->setSerieWeight("Probe", 2);
    $data->setPalette("Probe", array("R" => 0, "B" => 255, "G" => 128));
    $data->setAxisName(0, "Численность");

    $data->AddPoints($countries, "Labels");
    $data->setSerieDescription("Labels", "Страны");
    $data->setAbscissa("Labels");
    $data->setAbscissaName("Страны");

    return $data;
}

function getImage($x, $y, $data) {
    $image = new Image($x, $y, $data);
    $image->drawRectangle(0, 0, $x - 1, $y - 1);
    $image->setGraphArea(100, 40, $x-100, $y-170);
    $image->setFontProperties([
        "FontName" => "/server/data/fonts/tahoma.ttf", 
        "FontSize" => 10
    ]);

    return $image;
}

function setSettings($image) {
    $scaleSettings = array(
        "LabelRotation"=> 20, 
        "XMargin"=> 20,
        "YMargin"=> 10,
        "Floating"=>TRUE,
        "GridR"=>200,
        "GridG"=>200,
        "GridB"=>200,
        "DrawSubTicks"=>TRUE,
        "CycleBackground"=>TRUE );
    $image->drawScale($scaleSettings);
}

function generateLineChart($x, $y, $data, $file_path) {
    $img = getImage($x, $y, $data);
    setSettings($img);
    $img->Antialias = FALSE;
    
    $img->drawLineChart();
    $img->Antialias = True;
    
    $img->drawPlotChart([
        "ForceColor" => True,
        "ForceR" => 255,
        "ForceB" => 255,
        "ForceG" => 0
    ]);

    $img->Render($file_path);
}

function generateBarChart($x, $y, $data, $file_path) {
    $img = getImage($x, $y, $data);
    setSettings($img);
    $img->drawBarChart();

    $img->Render($file_path);
}

function generatePieChart($x, $y, $r, $data, $file_path) {
    $img = getImage($x, $y, $data);

    $pie = new Pie($img, $data);
    $pie->draw2DPie($x / 2, $y / 2, [
        'Radius' => $r,
        'DrawLabels' => true,
        "Border" => true,
        "BorderR" => 255,
        "BorderG" => 255,
        "BorderB" => 255
    ]);

    $pie->pChartObject->Render($file_path);
}


function generateGraphics($graphs) {
    $data = getData();
    $x = 1920;
    $y = 1080;
    generateLineChart($x, $y, $data, $graphs['line']['path']);
    generateBarChart($x, $y, $data, $graphs['bar']['path']);

    $r = min($x / 2, $y / 2) - 40;
    generatePieChart($x, $y, $r, $data, $graphs['pie']['path']);
}

?>