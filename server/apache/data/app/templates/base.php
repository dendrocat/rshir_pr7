<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?php echo $title ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <link rel="stylesheet" href="../css/apache-style.css" type="text/css">
    </head>
    <body class="<?php echo $theme ?>">
        <div class="nav">
            <a class="back" href="../nav.html">Назад</a>
        </div>
        <main>
            <h1><?php echo $title ?></h1>
            <?php 
                require_once "app/templates/" . $content; 
                if (isset($msg)) {
                    $class = $msg['type'] == Consts::successMsg ? "success" : "error";
                    $message = "<p class='{$class} msg'>{$msg['text']}</p>";
                    echo $message;
                }
            ?>
        </main>
    </body>
</html>