<?php
class Model_Material extends Model {
    public $name;

    function __construct() {
        parent::__construct("materials");
        $this->stmt_create = $this->prepare_stmt("INSERT INTO {$this->table} (name) VALUES (?)");
        $this->stmt_update = $this->prepare_stmt("UPDATE {$this->table} SET name = ? WHERE id =?");
    }

    public function parseJSON() {
        $data = getInput();
        if (isset($data->ID))
            $this->id = $data->ID;
        $this->name = $data->name;
    }

    public function create() {
        $this->stmt_create->bind_param("s", $this->name);
        return parent::create();
    }

    public function get() {
        $res = parent::get();
        if ($res) {
            $this->id = $res['id'];
            $this->name = $res['name'];
        }
        else $this->id = null;
    }


    public function update() {
        $this->stmt_update->bind_param("si", 
                            $this->name,  $this->id);
        return parent::update();
    }

    public function getArr() {
        return array(
            "id" => $this->id,
            "name" => $this->name
        );
    }

    public static function createArr($row) {
        return array(
            "id" => $row['id'],
            "name" => $row['name']
        );
    }

}
?>