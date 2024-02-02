<?php

namespace app\routes;

use app\controller\http\API\ExampleController;
use app\controller\http\ControllerRoutes;

ControllerRoutes::get("/", ExampleController::class, "index");
ControllerRoutes::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
