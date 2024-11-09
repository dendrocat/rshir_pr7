<?php

class Form {
    private $html;

    function __construct() {
        $this->html = "";
    } 

    function open($headers) {
        $method = isset($headers['method']) ? $headers['method'] : "post";
        $this->html = "<form method='" . $method . "'";
        if (isset($headers['action']))
            $this->html .= " action='" . $headers['action'] . "'";
        if (isset($headers['enctype']))
            $this->html .= " enctype='" . $headers['enctype'] . "'";
        $this->html .= ">";
    }

    private function addLabel($for, $label) {
        if (!empty($label)) {
            $this->html .= "<label for='{$for}'>{$label}</label>";
        }
    }

    function addFileField($type, $id, $accept, $label) {
        $this->addLabel($id, $label);
        $this->html .= "<input type='{$type}' id='$id' name='{$id}' accept='{$accept}'>";
    }

    function addInput($type, $id, $label) {
        $this->addLabel($id, $label);
        $this->html .= "<input type='{$type}' id='$id' name='{$id}'>";
    }

    function addSelect($id, $options, $label) {
        $this->addLabel($id, $label);
        $this->html .= "<select id='{$id}' name='{$id}'>";
        $first = true;
        foreach($options as $opt) {
            $this->html .= "<option value='{$opt['id']}'";
            $this->html .= $first ? "selected" : "";
            $this->html .= ">{$opt['name']}</option>";
            $first = false;
        }
        $this->html .= "</select>";
    }

    function addButton($text = 'Отправить форму') {
        $text = isset($text) ? $text : "Отправить форму";
        $this->html .= "<button type='submit'>{$text}</button>";
    }

    function addCheckbox($id, $label, $checked = false) {
        $this->addLabel($id, $label);
        $this->html .= "<input type='checkbox' id='{$id}' name='{$id}'";
        $this->html .= $checked ? "checked" : "";
        $this->html .= ">";
    }

    function close() {
        $this->html .= "</form>";
    }


    public function getForm() {
        return $this->html;
    }
}

?>