<?php
class DatabaseRedis {
    public static $was_logged = false;

    private static function getConnection() {
        $r = new Redis();
        $r->connect(Consts::redis_host, Consts::redis_port);
        return $r;
    }

    public static function loadData() {
        $r = self::getConnection();

        $login = "null";
        $pass = "null";
        if ($r->exists(Consts::kLogin))  {
            $login = $r->get(Consts::kLogin);
            $pass = $r->get(Consts::kPass);
        }
        
        $_SESSION[Consts::kLogin] = $login;
        $_SESSION[Consts::kPass] = $pass;
        $_SESSION[Consts::kTheme] = Consts::start_theme;

    }

    public static function loadTheme() {
        $kLogin = Consts::kLogin;
        $kTheme = Consts::kTheme;

        $r = self::getConnection();
        if ($r->exists($_SESSION[$kLogin]))
            $_SESSION[$kTheme] = $r->hget($_SESSION[$kLogin], $kTheme);
    }

    public static function saveTheme($login, $theme) {
        $kTheme = Consts::kTheme;

        $r = self::getConnection();
        if ($r->exists($login)) {
            $session_data = array($kTheme =>$theme);
            $r->hmset($login, $session_data);
        }
    }

    public static function saveSessionData() {
        $kLogin = Consts::kLogin;
        $kPass = Consts::kPass;
        $kTheme = Consts::kTheme;

        $r = self::getConnection();
        $r->set($kLogin, $_SESSION[$kLogin]);
        $r->set($kPass, $_SESSION[$kPass]);

        $session_data = array($kTheme => $_SESSION[$kTheme]);

        $r->hmset($_SESSION[$kLogin], $session_data);
    }
}
?>