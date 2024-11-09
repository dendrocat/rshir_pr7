<?php

class Controller_Product extends Controller {
    function __construct() {
        parent::__construct();
        $this->model = new Model_Product();
    }


    function all() {
        $data = [
            'title' => "Список товаров"
        ];
        $data['rows'] = $this->model->readAllWithMats();
        $data['columns'] = ['id', 'name', "price", "mat"];
        $data['heads'] = ['ID', 'Наименование', "Цена", "Материал"];
        $this->view->generate("template_read.php", "base.php", $data);
    }

    function generateForm($data = null) {
        $this->view->generate("template_form.php", "base.php", $data);
    }

    function handler_create() {
        if (empty($_POST['name']) 
            || empty($_POST['price']) || empty($_POST['mat'])) {
            setMsg("Все поля должны быть заполнены", Consts::errorMsg);
            back();
            die();
        }
        $this->model->name = $_POST['name'];
        $this->model->price = $_POST['price'];
        $this->model->mat = $_POST['mat'];
        $res = $this->model->create();
        if ($res)
            setMsg("Запись о товаре успешно создана", Consts::successMsg);
        else 
            setMsg("Ошибка при создании записи", Consts::errorMsg);
        back();
    }

    function create() {
        $data = [
            'title' => "Страница добавления товара"
        ];
        $form = new Form();
        $form->open(['action' => 'handler_create']);
        $form->addInput('text', 'name', 'Введите наименование товара');
        $form->addInput('number', 'price', 'Введите цену товара');
        $form->addSelect('mat', $this->model->getMats(), 'Выберите материал');
        $form->addButton("Добавить запись");
        $form->close();

        $data['form'] = $form;
        $this->generateForm($data);
    }

    function handler_delete() {
        if (empty($_POST['id'])) {
            setMsg("Поле ID должно быть заполнено", Consts::errorMsg);
            back();
            die();
        }
        $this->model->id = $_POST['id'];

        if ($this->model->delete()) 
            setMsg("Запись успешно удалена", Consts::successMsg);
        else 
            setMsg("Ошибка при удалении записи", Consts::errorMsg);
        back();
    }

    function delete() {
        $data = [
            "title" => 'Страница удаления товара'
        ];

        $form = new Form();
        $form->open(['action' => 'handler_delete']);
        $form->addInput('number', 'id', 'Введите ID товара');
        $form->addButton('Удалить запись');
        $form->close();

        $data['form'] = $form;
        $this->generateForm($data);
    }



}

?>