<?php
function replaceKeysFromSqlRes($rows, $cols, $replace) {
    $new_rows = array();

    foreach ($rows as $row) {
        $new_row = array();
        foreach ($cols as $col) {
            if (array_key_exists($col, $replace)) {
                $key = $replace[$col]['replace_key'];
                $trans = array("{{$key}}" => $row[$key]);
                
                $new_row += array($col => strtr($replace[$col]["stmt"], $trans));
            }
            else $new_row += array($col => $row[$col]);
        }
        array_push($new_rows, $new_row);
    }

    return $new_rows;
}

function setMsg($msg, $type) {
    $_SESSION['msg'] = [
        'text' => $msg,
        'type' => $type
    ];
}

function getMsg() {
    if (isset($_SESSION[Consts::kMsg])) {
        $msg =$_SESSION[Consts::kMsg];
        unset($_SESSION[Consts::kMsg]);
        return $msg;
    }
}

function back() {
    echo "<script> history.back() </script>";
}

function encodeMsg($msg) {
    return json_encode($msg, JSON_UNESCAPED_UNICODE);
}

function createMsg($msg) {
    return encodeMsg(array("message" => $msg));
}

function getInput() {
    return json_decode(file_get_contents("php://input"));
}
?>