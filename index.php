<?php
/**
 * File: index.php
 *
 * MMF (Monty Micro Framework). A PHP Micro Framework for Rest apps.
 * Created by Ivan Montilla <personal@ivanmontilla.es>
 *
 * Official website:  mmf-php.com
 * Documentation:     docs.mmf-php.com
 *
 * You have permission to use, adapt and redistribute this
 * code or adaption.
 * You can use this framework or adaption for make apps
 * with profit, but never sell this framework or adaption.
 *
 * Get started in docs.mmf-php.com/quickstart
 */
use MMF\Core\Environment;

define("IN_INDEX_FILE", true);

spl_autoload_register("mmfAutoload", true, true);

function mmfAutoload($class) {
    require_once str_ireplace("\\", "/", $class) . ".php";
}

if (Environment::isProductionEnvironment()) {
    error_reporting(0);
    ini_set("display_errors", false);
}

$path = [];

if (!isset($_SERVER["PATH_INFO"]) or $_SERVER["PATH_INFO"] == "/") {
    $path[0] = "App\\Controller\\" . Environment::getConfigObject()->Environment->controller;
    $path[1] = "index";
} else {
    $path = explode("/", $_SERVER["PATH_INFO"]);
    array_shift($path);
    $path[0] = "App\\Controller\\" . $path[0];
    if (!isset($path[1])) $path[1] = "index";
}

$params = [];

for ($i = 2; $i < count($path); $i++) {
    array_push($params, $path[$i]);
}

$controller = new $path[0];

$response = call_user_func_array([$controller, $path[1]], $params);
if (is_object($response)) {
    $response = get_object_vars($response);
} else {
    if (!is_array($response)) {
        throw new Exception(); //todo Crear clase para esta excepción.
    }
}

header('Content-Type: application/json');
echo json_encode($response);