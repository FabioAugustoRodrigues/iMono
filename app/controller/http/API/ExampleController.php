<?php

namespace app\controller\http\API;

use app\core\controller\ControllerAbstract;

class ExampleController extends ControllerAbstract
{

    public function getCurrentDateTime()
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

    public function index()
    {
        $this->view('index');
    }
}
