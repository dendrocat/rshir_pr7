<?php
function createAPI($model) {
    $model->parseJSON();

    if ($model->create()) {
        http_response_code(201);
        echo createMsg("Запись о товаре успешно создана");
    }
    else {
        http_response_code(400);
        echo createMsg("Невозможно создать запись о товаре");
    }
}
?>