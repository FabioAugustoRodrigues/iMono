<?php

namespace app\exception;

use RuntimeException;

class ApplicationException extends RuntimeException
{
    public function __construct($message)
    {
        parent::__construct($message, 0, null);
    }
}
