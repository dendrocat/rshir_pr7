<?php
function deleteAPI($model) {
    $model->id = $_GET['ID'];

    if ($model->delete()) {
        http_response_code(200);
        echo createMsg("Запись успешно удалена");
    }
    else {
        http_response_code(400);
        echo createMsg("Невозможно удалить запись c ID = {$model->id}");
    }
}
?>