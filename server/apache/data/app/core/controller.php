<?php

abstract class Controller {
    protected $model;
    protected $view;

    function __construct() {
        $this->view = new View();
    }

    public function all() {}

    public function index() {
        $api_dir = "app/api/";
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
                if (isset($_GET['ID'])) {
                    require_once $api_dir . "read_one.php";
                    read_oneAPI($this->model);
                }
                else {
                    require_once $api_dir . "read_all.php";
                    read_allAPI($this->model);
                }
                break;
            case "POST":
                require_once $api_dir . "create.php";
                createAPI($this->model);
                break;
            case "DELETE":
                require_once $api_dir . "delete.php";
                deleteAPI($this->model);
                break;
            case "PUT":
                require_once $api_dir . "update.php";
                updateAPI($this->model);
                break;
            default:
                http_response_code(400);
                echo createMsg("Неверный запрос");
        }
    }
}


?>