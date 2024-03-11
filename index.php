<?php

require_once './vendor/autoload.php';

require_once './app/routes/web.php';

use app\controller\http\Router;

session_start();

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");



date_default_timezone_set('America/Sao_Paulo');


$base_path = dirname($_SERVER['SCRIPT_NAME']);
$route = str_replace($base_path, '', $_SERVER['REQUEST_URI']);

$request_data = [];
$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method === 'GET') {
    $request_data = $_GET;
} else if ($request_method === 'POST') {
    $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

    if (strpos($content_type, 'application/json') !== false) {
        $json_data = file_get_contents('php://input');
        $request_data = json_decode($json_data, true);
    } else {
        $request_data = $_POST;
    }
} else if (in_array($request_method, ['PUT', 'PATCH', 'DELETE', 'OPTIONS'])) {
    $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

    if (strpos($content_type, 'application/json') !== false) {
        $json_data = file_get_contents('php://input');
        $request_data = json_decode($json_data, true);
    } else {
        parse_str(file_get_contents('php://input'), $request_data);
    }
}

if (isset($_FILES)) {
    $request_data = array_merge($request_data, $_FILES);
}

echo Router::run($request_data, $route, $request_method);
