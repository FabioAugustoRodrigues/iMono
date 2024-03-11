<?php

namespace app\routes;

use app\controller\http\API\ExampleController;
use app\controller\http\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. 
|
*/

Router::get("/", ExampleController::class, "index");
