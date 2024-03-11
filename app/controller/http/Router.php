<?php

namespace app\controller\http;

abstract class Router extends ControllerAbstract
{
    const PARAM_PATTERN = '/\{([^\/]+)\}/';

    private static $routes = array(
        'GET' => array(),
        'POST' => array(),
        'PUT' => array(),
        'DELETE' => array(),
        'PATCH' => array(),
        'OPTIONS' => array()
    );

    private static $middlewares = [];

    public static function addRoute($route, $class, $method, $request_method) {
        $route = self::transformRouteToRegex($route);

        if (!array_key_exists($route, self::$routes[$request_method])) {
            self::$routes[$request_method][$route] = new Method($class, $method);
        }
    }

    public static function get($route, $class, $method)
    {
        self::addRoute($route, $class, $method, "GET");
    }

    public static function post($route, $class, $method)
    {
        self::addRoute($route, $class, $method, "POST");
    }

    public static function put($route, $class, $method)
    {
        self::addRoute($route, $class, $method, "PUT");
    }

    public static function delete($route, $class, $method)
    {
        self::addRoute($route, $class, $method, "DELETE");
    }

    public static function patch($route, $class, $method)
    {
        self::addRoute($route, $class, $method, "PATCH");
    }

    public static function options($route, $class, $method)
    {
        self::addRoute($route, $class, $method, "OPTIONS");
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

    public static function run($request_data, $route, $request_method)
    {
        foreach (self::$routes[$request_method] as $routePattern => $methodObj) {
            if (preg_match($routePattern, $route, $matches)) {
                array_shift($matches);
    
                $middlewares = self::getMiddlewaresForRoute($routePattern);
                foreach ($middlewares as $middleware) {
                    $middleware->before($request_data);
                }
    
                return RequestHandler::handle($request_data, $methodObj, $matches, $middlewares);
            }
        }

        http_response_code(404);
        return "Route not found";
    }
}
