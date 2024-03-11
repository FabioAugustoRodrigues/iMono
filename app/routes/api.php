<?php

namespace app\routes;

use app\controller\http\API\ExampleController;
use app\controller\http\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
|
*/

Router::post("/api/getCurrentDateTime", ExampleController::class, "getCurrentDateTime");
