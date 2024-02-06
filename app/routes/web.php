<?php

namespace app\routes;

use app\http\controller\ControllerRoutes;

use app\http\controller\API\ExampleController;

ControllerRoutes::get("/", ExampleController::class, "index");
ControllerRoutes::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
