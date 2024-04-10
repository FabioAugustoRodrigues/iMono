<?php

namespace app\core;

use app\core\controller\Router;
use stdClass;

class Application
{

    public function __construct()
    {
    }

    public function run()
    {
        $request = $this->parseRequest();

        if (!in_array($request->method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
            http_response_code(405);
            echo "Method Not Allowed";
            die();
        }

        echo Router::run($request, $request->uri, $request->method);
    }

    private function parseRequest(): object
    {
        $request = new stdClass();
        $request->method = $_SERVER["REQUEST_METHOD"];
        $request->uri = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);
        $request->data = [];

        switch ($request->method) {
            case 'GET':
            case 'DELETE':
                $request->data = $_GET;
                break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
                $contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

                if (strpos($contentType, 'application/json') !== false) {
                    $jsonData = file_get_contents('php://input');
                    $request->data = json_decode($jsonData, true);
                } else {
                    parse_str(file_get_contents('php://input'), $request->data);
                }
                break;
        }

        if (isset($_FILES)) {
            $request->data = array_merge($request->data, $_FILES);
        }

        return $request;
    }
}
