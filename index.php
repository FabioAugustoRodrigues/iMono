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

$request_data = array();
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case "GET":
        $request_data = $_GET;
        break;
    case "POST":
        $request_data = $_POST;
        break;
    default:
        http_response_code(405);
        echo "Method Not Allowed";
        die();
}

if (isset($_FILES)) {
    $request_data = array_merge($request_data, $_FILES);
}

echo Router::run($request_data, $route, $request_method);