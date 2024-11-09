<?php
abstract class Model {
    private $db;
    protected $table;
    public $id;

    protected $stmt_create;
    protected $stmt_update;

    function __construct($table) {
        if (!empty($table)) {
            $this->db = DatabaseSQL::getConnection();
            $this->table = $table;
        }
    }

    protected function raw_query($q) {
        return $this->db->query($q);
    }
    protected function prepare_stmt($q) {
        return $this->db->prepare($q);
    }

    public function parseJSON() {
        $data = getInput();
        $this->id = $data->id;
    }

    public function create() {
        try {
            $res = $this->stmt_create->execute();
            $this->stmt_create->reset();
        }
        catch (Exception $e) {
            //echo $e->getMessage();
            return false;
        }
        return $res;
    }

    public function get() {
        $q = "SELECT * FROM " . $this->table . " WHERE id = " . $this->id;
        return DatabaseSQL::query($q)->fetch_assoc(); 
    }

    public function read_all() {
        $q = "SELECT * from " . $this->table;
        return DatabaseSQL::query($q);
    }

    public function update() {
        $res = $this->stmt_update->execute();
        $this->stmt_update->reset();
        return $res;
    }


    function delete() {
        $q = "DELETE FROM " . $this->table . " WHERE id = " . $this->id;
        try {
            $this->db->query($q);
            if ($this->db->affected_rows) return true;
            return false;
        }
        catch (Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }

    public function getArr() {
        return ["id" => $this->id];
    }

    public static function createArr($row) {
        return ["id" => $row['id']];
    }
}


?>