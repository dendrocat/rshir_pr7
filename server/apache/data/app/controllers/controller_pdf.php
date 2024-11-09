<?php

class Controller_Pdf extends Controller {
    function __construct() {
        parent::__construct();
        $this->model = new Model_Pdf();
    }

    private function generateForm($data) {
        $this->view->generate("template_form.php", "base.php", $data);
    } 

    function handler_download() {
        $uri = explode("/", $_SERVER['REQUEST_URI']);
        if (!isset($uri[3])) {
            back();
            die();
        }
        $this->model->id = $uri[3];
        $this->model->get();
    }

    function all() {
        $data = [
            "title" => "Список PDF файлов",
        ];
        
        $rows = $this->model->readAll();
        $data['columns'] = ['id', 'name', 'type', 'size', 'ref'];
        $replace = ['ref' => [
            'replace_key' => 'id',
            'stmt' => "<a href='handler_download/{id}'>Загрузить</a>"
        ]];

        $data['rows'] = replaceKeysFromSqlRes($rows, $data['columns'], $replace);
        $data['heads'] = ["ID", 'Имя файла','Тип файла', 'Размер файла', 'Ссылка'];
        
        $this->view->generate("template_read.php", "base.php", $data);
    }

    function handler_upload() {
        if (empty($_FILES['upfile']['tmp_name'])) {
            setMsg("Выберите файл", Consts::errorMsg);
        }
        else {
            $filename = $_FILES['upfile']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if (in_array($ext, ["pdf"])) {
                $file = file_get_contents($_FILES['upfile']['tmp_name']);
                if ($file === false) {
                    setMsg("Ошибка чтения файла", Consts::errorMsg);
                    back();
                }
                $this->model->filename = $filename;
                $this->model->file = $file;
                $this->model->filetype = $_FILES['upfile']['type'];
                $this->model->filesize = $_FILES['upfile']['size'];
                $this->model->create();
            }
            else {
                setMsg("Неправильное расширение файла. Поддерживаются только pdf", Consts::errorMsg);
            }
        }
        back();
    }

    function create() {
        $data = [
            "title" => "Загрузите файл на сервер"
        ];

        $form = new Form();
        $form->open(["action" => "handler_upload", 
                    'enctype' => "multipart/form-data"]);
        $form->addFileField('file', 'upfile', '.pdf', 'Выберите файл');
        $form->addButton("Загрузить файл");
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
        $this->model->id = $_POST["id"];
        if ($this->model->delete())
            setMsg("Файл успешно удален", Consts::successMsg);
        else setMsg("Ошибка при удалении записи", Consts::errorMsg);
        back();
    }

    function delete() {
        $data = [
            "title" => "Страница удаления файлов"
        ];

        $form = new Form();
        $form->open(["action" => "handler_delete"]);
        $form->addInput('number', 'id', 'Введите ID файла');
        $form->addButton('Удалить файл');
        $form->close();

        $data['form'] = $form;
        $this->generateForm($data);
    }
}

?>