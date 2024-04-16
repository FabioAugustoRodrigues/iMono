<?php

namespace app\core\controller;

class Request
{
    protected $data;
    protected $http_method;
    protected $uri;
    protected $headers;

    public function __construct($data, $http_method, $uri, $headers)
    {
        $this->data = $data;
        $this->http_method = $http_method;
        $this->uri = $uri;
        $this->headers = $headers;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getHttp_method()
    {
        return $this->http_method;
    }

    public function setHttp_method($http_method)
    {
        $this->http_method = $http_method;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }
}
