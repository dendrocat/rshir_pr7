<?php
require_once "app/core/util.php";

class Controller_Graph extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->model = new Model_Graph();
    }

    function all() {
        $data = [
            "title" => "Графики"
        ];

        $rows = $this->model->read_all();
        $data['columns'] = ['name', 'img'];

        $replace = ['img' => [
            'replace_key' => 'path',
            'stmt' => "<img src='{path}' class='graph'>"
        ]];

        $data['rows'] = replaceKeysFromSqlRes($rows, $data['columns'], $replace);
        $data['heads'] = ['Название', 'График'];
        $this->view->generate("template_read.php", "base.php", $data);
    } 
}


?>