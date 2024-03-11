<?php

namespace app\routes;

use app\controller\http\API\ExampleController;
use app\controller\http\Router;

Router::get("/", ExampleController::class, "index");
Router::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
