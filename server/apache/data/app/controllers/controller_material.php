<?php

class Controller_Material extends Controller {
    function __construct() {
        parent::__construct();
        $this->model = new Model_Material();
    }
}
?>