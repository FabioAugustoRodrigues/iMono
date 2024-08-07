<?php

namespace app\core\controller;

use app\util\View;

abstract class ControllerAbstract
{

    protected function createResponse($data = null, int $status = 200)
    {
        return new Response($data, $status);
    }

    protected function respond($data = null, int $status)
    {
        return $this->createResponse($data, $status)->send();
    }

    protected function respondJson($data = null, int $status)
    {
        return $this->createResponse($data, $status)->withHeader("Content-Type: application/json; charset=utf-8")
            ->withHeader("Content-Type: application/json")
            ->send();
    }

    protected function view($filename, $data = [])
    {
        View::render($filename, $data);
    }

    protected function formatJson(string $json)
    {
        $json = preg_replace('/,/', '$0 ', $json);

        return $json;
    }
}
