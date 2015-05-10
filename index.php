<?php

session_start();
$passHash = password_hash('123', PASSWORD_BCRYPT);
require_once('includes/config.php');
if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) > -1) {
    $url = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME']) + 1);
} else {
    $url = $_SERVER['REQUEST_URI'];
}
$requestParts = explode('/', $url, PHP_URL_PATH);

$controllerName = DEFAULT_CONTROLLER;


if (count($requestParts) >= 2 && $requestParts[1] != '') {
    $controllerName = $requestParts[1];
}

$action = DEFAULT_ACTION;
if (count($requestParts) >= 3 && $requestParts[2] != '') {
    $action = $requestParts[2];
}

$params = (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) > -1) ? array_splice($requestParts, 0) : array_splice($requestParts, 3);

$controllerClassName = ucfirst(strtolower($controllerName)) . 'Controller';
$controllerFileName = "controllers/" . $controllerClassName . '.php';

if (class_exists($controllerClassName)) {
    $controller = new $controllerClassName($controllerName, $action);
} else {
    die("Cannot find controller '$controllerName' in class '$controllerFileName'");
}

if (method_exists($controller, $action)) {
    //$controller->{$action}($params);
    call_user_func_array(array($controller, $action), $params);
    $controller->renderView();
} else {
    die("Cannot find action '$action' in controller '$controllerClassName'");
}

$controller->renderView();


function __autoload($class_name) {
    if (file_exists("controllers/$class_name.php")) {
        include "controllers/$class_name.php";
    }
    if (file_exists("models/$class_name.php")) {
        include "models/$class_name.php";
    }
}
