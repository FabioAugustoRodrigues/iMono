<?php

namespace app\core;

use app\core\controller\Request;
use app\core\controller\Router;

class Application
{

    public function __construct()
    {
    }

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
        $uri = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);
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
