<?php

namespace app\exception\http;

use app\exception\ApplicationException;

class ApplicationHttpException extends ApplicationException {

    protected $httpStatusCode;

    public function __construct($message, int $status = 500) {
        parent::__construct($message);
        $this->httpStatusCode = $status;
    }

    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
}