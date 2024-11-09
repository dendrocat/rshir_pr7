<?php

class Model_Pdf extends Model {
    public $file;
    public $filetype;
    public $filesize;
    public $filename;

    function __construct() {
        parent::__construct("pdf_files");
    }


    public function readAll() {
        return parent::read_all();
    }


    public function get() {    
        $stmt = $this->prepare_stmt("SELECT name, type, size, data FROM pdf_files where id=?");
        $stmt->bind_param("i", $this->id);
        
        if ($stmt->execute()) {
            $stmt->bind_result($name, $type, $size, $data);
            if ($stmt->fetch()) { 
                header("Content-Type: " . $type);
                header('Content-Disposition: attachment; filename="' . $name . '"');
                header("Content-Length: " . $size);
            
            }
            echo $data;
        }
        $stmt->close();
    }

    public function create($q = null) {
        $stmt = $this->prepare_stmt("INSERT INTO pdf_files (name, type, size, data) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $this->filename, $this->filetype, $this->filesize, $this->file);
        
        if ($stmt->execute())
            setMsg("Файл {$this->filename} успешно загружен", Consts::successMsg);
        else 
            setMsg("Ошибка загрузки файла" . $stmt->error, Consts::errorMsg);
        $stmt->close();
    }
}

?>