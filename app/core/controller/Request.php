<?php

namespace app\core\controller;

class Request
{
    protected $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    public function getParams()
    {
        if (isset($this->params->data)) {
            return $this->params->data;
        }

        return [];
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
}
