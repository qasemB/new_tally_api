<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, OPTIONS');
header('Access-Control-Allow-Headers: Accept, Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With, Origin, X-Auth-Token');

require(__DIR__.'/vendor/autoload.php');
require(__DIR__."/DB.php");
require(__DIR__."/core.php");
require(__DIR__."/Controllers/controller.php");
require(__DIR__."/Controllers/auth.php");


// define varables
$httpMethod = $_SERVER['REQUEST_METHOD'];

//get uri
$request_uri = $_SERVER['REQUEST_URI'];


// clear url
$url = rtrim($request_uri, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);

//query string management --------
$urlArr = explode('?', $url);
if (sizeof($urlArr) > 1) {
    Controller::$queryStr = $urlArr[1];
    $url = $urlArr[0];
}

//segmentation url (ex: localhost/api/controller/method)
$url = explode('/', $url);
if (sizeof($url) <= 1) apiError('Not found', 404);
if (sizeof($url) <= 2) apiError('No Controller is exist', 404);
$controllerSelected = (string) $url[2];
$methodSelected = (string) $url[3];

if (isset($url[4]) && $url[4] != null) {
    $id = (int) $url[4];
    Controller::$id = (int) $url[4];
}

// class and method not found-----------
if (!in_array($controllerSelected, Controller::getControllersList())) {
    apiError("Controller is not exist", 404);
}
if (!method_exists("Auth", $methodSelected)) {
    apiError("Method is not exist", 404);
}

// call method
try {
    call_user_func($controllerSelected."::".$methodSelected);
} catch (Exception $e) {
    apiError($e);
}
