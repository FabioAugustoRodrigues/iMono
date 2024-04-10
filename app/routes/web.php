<?php

namespace app\routes;

use app\core\controller\Router;
use app\http\controller\ExampleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. 
|
*/

Router::get("/", ExampleController::class, "index");
