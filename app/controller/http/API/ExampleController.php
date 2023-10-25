<?php

namespace app\controller\http\API;

use app\controller\http\ControllerAbstract;

require_once '../../../vendor/autoload.php';

class ExampleController extends ControllerAbstract
{

    public function __construct(
    ) {
    }

    public function getCurrentDateTime() {
        return $this->respondsWithData(
            [
                "data" => [
                    "current_date_time" => date('Y-m-d H:i:s')
                ],
                "message" => ""
            ],
            200
        );
    }

}