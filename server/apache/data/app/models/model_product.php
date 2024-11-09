<?php

class Model_Product extends Model {
    public $name;
    public $price;
    public $mat;

    function __construct() {
        parent::__construct("products");
        $this->stmt_create = $this->prepare_stmt("INSERT INTO {$this->table} (name, price, mat_id) VALUES (?, ?, ?)");
        $this->stmt_update = $this->prepare_stmt("UPDATE {$this->table} SET name = ?, price = ?, mat_id = ? WHERE id =?");
    }

    public function parseJSON() {
        $data = getInput();
        if (isset($data->ID))
            $this->id = $data->ID;
        $this->name = $data->name;
        $this->price = $data->price;
        $this->mat = $data->matID;
    }

    public function create() {
        $this->stmt_create->bind_param("sii", $this->name, $this->price, $this->mat);
        return parent::create();
    }

    public function get() {
        $res = parent::get();
        if ($res) {
            $this->id = $res['id'];
            $this->name = $res['name'];
            $this->price = $res['price'];
            $this->mat = $res['mat_id'];
        }
        else $this->id = null;
    }

    public function readAllWithMats() {
        $q = "SELECT p.id as id, p.name as name, 
                p.price as price, m.name as mat 
                from {$this->table} as p 
                join materials as m 
                on p.mat_id = m.id
                order by p.id";
        return $this->raw_query($q);
    }

    public function update() {
        $this->stmt_update->bind_param("siii", 
                            $this->name, $this->price,
                            $this->mat, $this->id);
        return parent::update();
    }

    public function getMats() {
        require_once "app/models/model_material.php";
        $model = new Model_Material();
        return $model->read_all();
    }

    public function getArr() {
        return ["id" => $this->id,
            "name" => $this->name,
            "price" => $this->price,
            "mat" => $this->mat];
    }

    public static function createArr($row) {
        return["id" => $row['id'],
            "name" => $row['name'],
            "price" => $row['price'],
            "mat" => $row['mat_id']];
    }
}
?>