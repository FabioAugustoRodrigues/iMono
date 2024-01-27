<?php

namespace app\controller\http;

use app\exception\ApplicationException;
use app\exception\http\ApplicationHttpException;
use Exception;

require_once "../../../vendor/autoload.php";

class ControllerRoutes extends ControllerAbstract
{
    private static $routes;
    private static $middlewares = [];

    public function __construct()
    {
        self::$routes = array();

        $this->addRoute("/api/getCurrentDateTime", "app\\controller\\http\\API\\ExampleController", "getCurrentDateTime");
    }

    public function addRoute($route, $class, $method)
    {
        if (!array_key_exists($route, self::$routes)) {
            self::$routes[$route] = new Method($class, $method);
        }

        return $this;
    }

    public function addMiddleware($route, $middleware)
    {
        if (!array_key_exists($route, self::$middlewares)) {
            self::$middlewares[$route] = [];
        }
        self::$middlewares[$route][] = $middleware;

        return $this;
    }

    private function getMiddlewaresForRoute($route)
    {
        return self::$middlewares[$route] ?? [];
    }

    public function run($post, $route)
    {
        if (array_key_exists($route, self::$routes)) {
            $method = self::$routes[$route];

            $middlewares = $this->getMiddlewaresForRoute($route);
            foreach ($middlewares as $middleware) {
                $middleware->before($post);
            }

            $container = require_once __DIR__ . "../../../config/container.php";

            try {
                $response = $container->call([self::$routes[$route]->getClass(), self::$routes[$route]->getMethod()], array($post));

                foreach ($middlewares as $middleware) {
                    $middleware->after($post, $response);
                }

                return $response;
            } catch (ApplicationHttpException $applicationHttpException) {
                return $this->respondsWithData(
                    $applicationHttpException->getMessage(),
                    $applicationHttpException->getHttpStatusCode()
                );
            } catch (ApplicationException $applicationException) {
                return $this->respondsWithData(
                    $applicationException->getMessage(),
                    500
                );
            } catch (Exception $exception) {
                return $this->respondsWithData(
                    "There was an error during the operation.",
                    500
                );
            }
        } 

        http_response_code(404);
        return "Route not fassound";
    }
}