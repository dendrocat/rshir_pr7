<?php
function read_allAPI($model) {

    $res = $model->read_all();

    if ($res->num_rows) {
        $models = array();

        foreach ($res as $row)
            array_push($models, $model::createArr($row));

        http_response_code(200);
        echo encodeMsg($models);
    }
    else {
        http_response_code(404);
    }
}
?>