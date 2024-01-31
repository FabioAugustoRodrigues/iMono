<?php

namespace app\routes;

use app\controller\http\ControllerRoutes;

ControllerRoutes::get("/", "app\\controller\\http\\API\\ExampleController", "index");
ControllerRoutespost("/api/getCurrentDateTime", "app\\controller\\http\\API\\ExampleController", "getCurrentDateTime");