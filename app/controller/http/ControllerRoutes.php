<?php

namespace app\controller\http;

use app\exception\ApplicationException;
use app\exception\http\ApplicationHttpException;
use Exception;

class ControllerRoutes extends ControllerAbstract
{
    private static $routes;
    private static $middlewares = [];

    public function __construct()
    {
        self::$routes = array('GET' => array(),
                              'POST' => array()
        );

        $this->get("/api/getCurrentDateTime", "app\\controller\\http\\API\\ExampleController", "getCurrentDateTime");
    }

    public function get($route, $class, $method)
    {
        if (!array_key_exists($route, self::$routes['GET'])) {
            self::$routes['GET'][$route] = new Method($class, $method);
        }

        return $this;
    }

    public function post($route, $class, $method)
    {
        if (!array_key_exists($route, self::$routes['POST'])) {
            self::$routes['POST'][$route] = new Method($class, $method);
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

    public function run($post, $route, $method)
    {

        // erro aqui
        if (array_key_exists($route, self::$routes[$method])) {
            $method = self::$routes[$method][$route];

            $middlewares = $this->getMiddlewaresForRoute($route);
            foreach ($middlewares as $middleware) {
                $middleware->before($post);
            }

            $container = require_once __DIR__ . "../../../config/container.php";

            try {
                $response = $container->call([self::$routes[$method][$route]->getClass(), self::$routes[$method][$route]->getMethod()], array($post));

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
        return "Route not found";
    }
}