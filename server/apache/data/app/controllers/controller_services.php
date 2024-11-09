<?php

class Controller_Services extends Controller {

    function __construct() {
        parent::__construct();
        $this->model = new Model_Services();
    }

    public function drawer() {
        $data = ['title' => "Drawer"];
        if (!isset($_GET['ID'])) {
            setMsg("Не указан ID рисунка", Consts::errorMsg);
        }
        else {
            $data['size'] = 300;
            $data['img'] = $this->model->draw($_GET['ID'], $data['size']);
        }
        $this->view->generate("template_drawer.php", "base.php", $data);
    }

    public function sort() {
        $data = ['title' => "Сортировка массива"];
        if (!isset($_GET['arr'])) {
            setMsg("Не указан массив", Consts::errorMsg);
        }
        else {
            $arr = explode(',', $_GET['arr']);
            $arr = array_map('intval', $arr);
            
            $data += [
                'until' => $arr,
                'after' =>  $this->model->sortShell($arr)
            ];
        }
        $this->view->generate("template_sort.php", "base.php", $data);
    }
    public function shell() {
        $coms = ['ls -a', 'pwd', 'uname -m -s', 'date'];
        $data = [
            'title' => "Команды",
            'comands' => array()
        ];
        foreach($coms as $com) {
            array_push($data['comands'], 
                    array('comand' => $com, 
                        'res' => $this->model->exec($com)));
        }

        $this->view->generate("template_shell.php", "base.php", $data);
    }
}

?>