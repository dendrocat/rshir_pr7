<?php

class View {
    public function generate($content, $template, $data) {
        if (is_array($data)) {
            extract($data);
            unset($data);
        }
        $theme = $_SESSION[Consts::kTheme];
        $msg = getMsg();

        require_once "app/templates/".$template;
    }
}

?>