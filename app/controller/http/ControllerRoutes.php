<?php

namespace app\controller\http;

use app\exception\ApplicationException;
use app\exception\http\ApplicationHttpException;
use Exception;

abstract class ControllerRoutes extends ControllerAbstract
{
    const PARAM_PATTERN = '/\{([^\/]+)\}/';

    private static $routes = array(
        'GET' => array(),
        'POST' => array()
    );

    private static $middlewares = [];

    public static function get($route, $class, $method)
    {
        $route = self::transformRouteToRegex($route);

        if (!array_key_exists($route, self::$routes['GET'])) {
            self::$routes['GET'][$route] = new Method($class, $method);
        }
    }

    public static function post($route, $class, $method)
    {
        $route = self::transformRouteToRegex($route);

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

    private static function transformRouteToRegex($route)
    {
        $route = preg_replace(self::PARAM_PATTERN, '([^\/]+)', $route);
        $route = '#^' . $route . '$#';

        return $route;
    }

    public static function run($post, $route, $request_method)
    {
        foreach (self::$routes[$request_method] as $routePattern => $methodObj) {
            if (preg_match($routePattern, $route, $matches)) {
                array_shift($matches);

                $middlewares = self::getMiddlewaresForRoute($routePattern);
                foreach ($middlewares as $middleware) {
                    $middleware->before($post);
                }

                $container = require_once __DIR__ . "../../../config/container.php";

                try {
                    $response = $container->call([$methodObj->getClass(), $methodObj->getMethod()], array_merge([$post], $matches));

                    foreach ($middlewares as $middleware) {
                        $middleware->after($post, $response);
                    }

                    return $response;
                } catch (ApplicationHttpException $applicationHttpException) {
                    return self::respondJson(
                        $applicationHttpException->getMessage(),
                        $applicationHttpException->getHttpStatusCode()
                    );
                } catch (ApplicationException $applicationException) {
                    return self::respondJson(
                        $applicationException->getMessage(),
                        500
                    );
                } catch (Exception $exception) {
                    return self::respondJson(
                        "There was an error during the operation.",
                        500
                    );
                }
            }
        }

        http_response_code(404);
        return "Route not found";
    }
}