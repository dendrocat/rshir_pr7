<?php

function read_oneAPI($model) {
    $model->id = $_GET['ID'];

    $model->get();

    if ($model->id) {
        http_response_code(200);
        echo encodeMsg($model->getArr());
    }
    else {
        http_response_code(404);
    }
}
?>