<?php

namespace app\routes;

use app\core\controller\Router;
use app\http\controller\ExampleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Router::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
