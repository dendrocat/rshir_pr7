<?php

class Controller_Settings extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->model = new Model_Settings();
    }

    function apply() {
        $theme = isset($_POST['theme']) ? 'dark' : Consts::start_theme;
        $this->model->theme = $theme;
        $this->model->update();

        setMsg("Сохранено", Consts::successMsg);
        back();
    }

    function index() {
        $data = $this->model->read_all();
        $data += [
            "title" => "Настройки"
        ];

        $form = new Form();
        $form->open(['action' => "settings/apply"]);
        $form->addCheckbox('theme', 'Темная тема', $data['theme'] != Consts::start_theme);
        $form->addButton("Применить");
        $form->close();

        $data['form'] = $form;
        $this->view->generate("template_settings.php", "base.php", $data);
    } 
}


?>