<?php

namespace app\exception;

use RuntimeException;

class RouteNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Route not found", 0, null);
    }
}
