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

function requestData($isFormData=0){
    if ($isFormData == 1) {
        return $_POST;
    }else{
        $json = file_get_contents('php://input');
        return json_decode($json);
    }

}