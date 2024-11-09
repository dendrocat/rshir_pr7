<?php

class Controller_User extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->model = new Model_User();
    }

    function all() {
        $data = [
            "title" => "Список пользователей"
        ];

        $data['rows'] = $this->model->readAllWithGroups();
        $data['columns'] = ['id', 'name', 'passwd', 'g_name'];
        $data['heads'] = ['ID', 'Логин', 'Пароль', 'Группа'];
        $this->view->generate("template_read.php", "base.php", $data);
    } 
}


?>