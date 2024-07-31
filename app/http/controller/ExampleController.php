<?php

namespace app\http\controller;

use app\core\controller\ControllerAbstract;
use app\core\controller\Request;

class ExampleController extends ControllerAbstract
{

    public function getCurrentDateTime(Request $request)
    {
        return $this->respondJson(
            [
                "data" => [
                    "current_date_time" => date('Y-m-d H:i:s')
                ],
                "message" => ""
            ],
            200
        );
    }

    public function index(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];

        $this->view(
            'index',
            [
                'host' => $host
            ]
        );
    }
}
