<?php

class Model_Settings extends Model {
    private $login;
    private $passwd;
    public $theme;

    function __construct() {
        $this->login = $_SESSION[Consts::kLogin];
        $this->passwd = $_SESSION[Consts::kPass];
        $this->theme = $_SESSION[Consts::kTheme];
    }

    function read_all() {
        return ['last_login' => $this->login,
        'last_pass' => $this->passwd,
        'theme' => $this->theme];
    }

    function update() {
        DatabaseRedis::saveTheme($this->login, $this->theme);
        $_SESSION[Consts::kTheme] = $this->theme;
    }

}