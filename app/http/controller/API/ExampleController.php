<?php

namespace app\http\controller\API;

use app\http\controller\ControllerAbstract;

class ExampleController extends ControllerAbstract
{

    public function getCurrentDateTime() {
        
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

    public function index() {

        require('./app/views/index.html');

    }

}