<?php

namespace app\controller\http;

use app\util\PayloadHttp;

class Response
{
    private $data;
    private $status;
    private $headers = [];

    public function __construct($data = null, int $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function withHeader(string $header)
    {
        $this->headers[] = $header;
        return $this;
    }

    public function send()
    {
        $payload = new PayloadHttp($this->status, $this->data);

        foreach ($this->headers as $header) {
            header($header);
        }

        http_response_code($payload->getStatus());
        
        echo json_encode($payload);
    }
}