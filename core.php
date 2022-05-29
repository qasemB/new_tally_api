<?php 
function JSON($arr = []){
    return json_encode($arr);
}
function apiError($msg, $code=null){
    if(isset($code)) http_response_code($code);
    echo JSON([
        'error' => true,
        'reason' => $msg
    ]);
    die;
}