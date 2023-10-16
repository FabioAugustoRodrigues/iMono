<?php

namespace app\util;

use JsonSerializable;

require_once '../../../vendor/autoload.php';

class PayloadHttp implements JsonSerializable
{
    private $status;
    private $data;

    public function __construct(
        int $status = 200, 
        $data = null
    ) {
        $this->status = $status;
        $this->data = $data;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getData()
    {
        return $this->data;
    }

    public function jsonSerialize()
    {
        $payload = [];

        if (is_array($this->data)) {
            $payload = $this->data;
        } else if ($this->data !== null) {
            $payload[] = $this->data;
        } 
        
        return $payload;
    }
}