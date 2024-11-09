<?php

class Controller_City extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->model = new Model_City();
    }

    function all() {
        $data = [
            "title" => "Список городов"
        ];

        $data['rows'] = $this->model->read_all();
        $data['columns'] = ['name', 'postcode', 'number', 'mayor', 'country'];
        $data['heads'] = ['Название', 'Индекс', 'Численность населения', 'Мэр', 'Страна'];
        $this->view->generate("template_read.php", "base.php", $data);
    } 
}


?>