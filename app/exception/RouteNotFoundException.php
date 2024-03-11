<?php

namespace app\exception;

use RuntimeException;

class RouteNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Route not found", 0, null);

        $this->requireNotFoundPage();
    }

    private function requireNotFoundPage(): void
    {
        http_response_code(404);
        if (is_file('./app/views/404.html')) {
            require('./app/views/404.html');
        } else {
            echo "404 - Route not found";
        }

        exit;
    }
}
