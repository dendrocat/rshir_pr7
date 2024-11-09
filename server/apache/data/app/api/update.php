<?php

function updateAPI($model) {
    $model->parseJSON();


    if ($model->update()) {
        http_response_code(200);
        echo createMsg("Запись была успешно изменена");
    }
    else {
        http_response_code(404);
        echo createMsg("Невозможно изменить запись с ID = {$model->id}");
    }
}
?>