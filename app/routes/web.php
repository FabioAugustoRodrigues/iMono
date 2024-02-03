<?php

namespace app\routes;

use app\http\controller\API\ExampleController;
use app\http\controller\ControllerRoutes;

ControllerRoutes::get("/", ExampleController::class, "index");
ControllerRoutes::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
