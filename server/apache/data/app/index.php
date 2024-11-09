<?php
require_once "core/consts.php";
require_once "core/util.php";
require_once "core/database_sql.php";
require_once "core/database_redis.php";

require_once "core/form.php";
require_once "core/view.php";
require_once "core/model.php";
require_once "core/controller.php";

session_start();
if (!DatabaseRedis::$was_logged) {

    $_SESSION[Consts::kLogin] = $_SERVER['PHP_AUTH_USER'];
    $_SESSION[Consts::kPass] = $_SERVER['PHP_AUTH_PW'];

    DatabaseRedis::loadTheme();
    DatabaseRedis::saveSessionData();
    DatabaseRedis::$was_logged = true;
}

require_once "core/route.php";
Route::start();
?>