<?php



session_start();

header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: *");
header('content-type: application/json; charset=utf-8');
header('Content-Type: application/json');

require_once '../../../vendor/autoload.php';

use app\controller\http\ControllerRoutes;

date_default_timezone_set('America/Sao_Paulo');

$inputJSON = file_get_contents('php://input');
$_POST = json_decode($inputJSON, true);

if (isset($_POST['route'])) {
    $post = $_POST;
    if (isset($_FILES)) {
        $post = array_merge($_POST, $_FILES);
    }

    $controller = new ControllerRoutes();
    echo $controller->run($post, $_POST['route']);
} else {
    http_response_code(404);
    echo json_encode("Route not found");
}