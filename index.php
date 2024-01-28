<?php

require_once './vendor/autoload.php';

use app\controller\http\ControllerRoutes;

session_start();

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
header('Content-Type: application/json');



date_default_timezone_set('America/Sao_Paulo');

$route = $_SERVER['REQUEST_URI'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $post = $_GET;
    if (isset($_FILES)) {
        $post = array_merge($_GET, $_FILES);
    }

    $controller = new ControllerRoutes();
    echo $controller->run($post, $route, 'GET');
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post = $route;
    if (isset($_FILES)) {
        $post = array_merge($route, $_FILES);
    }

    $controller = new ControllerRoutes();
    echo $controller->run($post, $route, 'POST');

} else {
    http_response_code(404);
    echo json_encode("Route not found");
}