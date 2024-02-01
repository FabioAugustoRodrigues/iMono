<?php

namespace app\routes;

use app\controller\http\ControllerRoutes;

ControllerRoutes::get("/", "app\\controller\\http\\API\\ExampleController", "index");
ControllerRoutes::post("/api/getCurrentDateTime", "app\\controller\\http\\API\\ExampleController", "getCurrentDateTime");