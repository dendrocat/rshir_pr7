<?php

class Route {
    private static $groupFile = "/etc/apache2/access/.group";
    private static $admin_urls = ['/user/all'];

    private static function checkAdminGroup($url) {
        $groups = file(self::$groupFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        list($groupName, $users) = explode(":", $groups[0], 2);
        $users = explode(" ", $users);
        if (!in_array($_SESSION[Consts::kLogin], $users)) {
            self::ErrorPage(403);
            die();
        }

    }


    public static function start() {
        $url = explode("?", $_SERVER['REQUEST_URI'])[0];
        if (in_array($url, self::$admin_urls)) {
            self::checkAdminGroup($url);
        }
        $url = explode("/", $url);

        if (in_array($url[1], Consts::onePage)) {
            require_once "app/{$url[1]}.php";
            die();
        }
        $controller_name = ucfirst($url[1]);
        $action = "index";
        if (!empty($url[2]))
            $action = $url[2];

        $model_name = "Model_" . $controller_name;
        $controller_name = "Controller_" . $controller_name;

        $file_name = "app/controllers/" . strtolower($controller_name) . ".php";
        if (!file_exists($file_name)) {
            self::ErrorPage(404);
        }
        require_once $file_name;

        $file_name = "app/models/" . strtolower($model_name) . ".php";
        if (!file_exists($file_name)) {
            self::ErrorPage(404);
        }
        require_once $file_name;

        $controller = new $controller_name();
        if (!method_exists($controller, $action))
            self::ErrorPage(404);
        else $controller->$action();
    }

    private static function ErrorPage($code) {
        header("HTTP/1.1 {$code} Not Found");
		header("Status: {$code} Not Found");
    }
}

?>