<?php

namespace app\routes;

use app\controller\http\API\ExampleController;
use app\core\controller\Router;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. 
|
*/

Router::get("/", ExampleController::class, "index");
