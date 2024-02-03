<?php

namespace app\http\controller;

use app\exception\ApplicationException;
use app\exception\http\ApplicationHttpException;
use Exception;

class ControllerRoutes extends ControllerAbstract
{
    private static $routes = array('GET' => array(),
                              'POST' => array());
    private static $middlewares = [];


    public static function get($route, $class, $method)
    {
        if (!array_key_exists($route, self::$routes['GET'])) {
            self::$routes['GET'][$route] = new Method($class, $method);
        }
    }

    public static function post($route, $class, $method)
    {
        if (!array_key_exists($route, self::$routes['POST'])) {
            self::$routes['POST'][$route] = new Method($class, $method);
        }
    }

    public static function addMiddleware($route, $middleware)
    {
        if (!array_key_exists($route, self::$middlewares)) {
            self::$middlewares[$route] = [];
        }
        self::$middlewares[$route][] = $middleware;

    }

    private static function getMiddlewaresForRoute($route)
    {
        return self::$middlewares[$route] ?? [];
    }

    public static function run($post, $route, $request_method)
    {

        if (array_key_exists($route, self::$routes[$request_method])) {
            $methodObj = self::$routes[$request_method][$route];

            $middlewares = self::getMiddlewaresForRoute($route);
            foreach ($middlewares as $middleware) {
                $middleware->before($post);
            }

            $container = require_once __DIR__ . "../../../config/container.php";

            try {
                $response = $container->call([$methodObj->getClass(), $methodObj->getMethod()], array($post));


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