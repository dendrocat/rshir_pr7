<?php 
    http_response_code(401);
    unset($_SESSION[Consts::kLogin]);
    unset($_SESSION[Consts::kPass]);
    $_SESSION[Consts::kTheme] = Consts::start_theme;
    DatabaseRedis::$was_logged = false;
    back();
?>