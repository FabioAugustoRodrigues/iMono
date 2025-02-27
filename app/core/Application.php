<?php

namespace app\core;

use app\core\controller\Request;
use app\core\controller\Router;

class Application
{

    public function __construct() {}

    public function run()
    {
        $request = $this->parseRequest();

        if (!in_array($request->getHttp_method(), ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            http_response_code(405);
            echo "Method Not Allowed";
            die();
        }

        echo Router::dispatch($request);
    }

    private function parseRequest(): Request
    {
        $http_method = $_SERVER["REQUEST_METHOD"];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        if (strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }
        $uri = '/' . ltrim($uri, '/');

        $data = [];
        $headers = getallheaders();

        switch ($http_method) {
            case 'GET':
            case 'DELETE':
                $data = $_GET;
                break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
                $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

                if (strpos($contentType, 'application/json') !== false) {
                    $jsonData = file_get_contents('php://input');
                    $data = json_decode($jsonData, true);
                } else {
                    parse_str(file_get_contents('php://input'), $data);
                }
                break;
        }

        if (isset($_FILES)) {
            $data = array_merge($data, $_FILES);
        }

        return new Request(
            $data,
            $http_method,
            $uri,
            $headers
        );
    }
}
