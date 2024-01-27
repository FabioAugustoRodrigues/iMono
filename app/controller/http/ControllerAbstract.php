<?php

namespace app\controller\http;

use app\util\PayloadHttp;

abstract class ControllerAbstract
{
    public function __construct() {}

    protected function respondsWithData($data = null, int $status = 200)
    {
        $payload = new PayloadHttp($status, $data);
        return $this->responds($payload);
    }

    protected function responds(PayloadHttp $payload)
    {
        $json = json_encode($payload);
        $json = $this->formatJson($json);

        http_response_code($payload->getStatus());

        return $json;
    }

    protected function formatJson(string $json)
    {
        $json = preg_replace('/,/', '$0 ', $json);

        return $json;
    }

}