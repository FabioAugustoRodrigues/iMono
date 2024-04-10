<?php

namespace app\core\controller;

use app\exception\RouteNotFoundException;
use Closure;

abstract class Router
{
    private static $tempMiddleware;

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

    public static function addRoute($route, $class, $method, $request_method)
    {
        $route = self::transformRouteToRegex($route);
        $route = self::removeLastSlashFromRoute($route);

        if (!array_key_exists($route, self::$routes[$request_method])) {
            self::$routes[$request_method][$route] = new Method($class, $method);

            if (self::$tempMiddleware) {
                self::$middlewares[$route][] = self::$tempMiddleware;
            }
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
        $route = self::transformRouteToRegex($route);
        $route = self::removeLastSlashFromRoute($route);

        if (!array_key_exists($route, self::$middlewares)) {
            self::$middlewares[$route] = [];
        }

        self::$middlewares[$route][] = $middleware;
    }

    public static function group(array $options, Closure $callback)
    {
        $middleware = $options['middleware'] ?? null;

        if ($middleware) {
            self::$tempMiddleware = $middleware;
        }

        call_user_func($callback);

        self::$tempMiddleware = null;
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

    private static function removeLastSlashFromRoute($route)
    {
        if ($route == "/") {
            return $route;
        }

        return rtrim($route, "/");
    }

    public static function run($request_data, $route, $request_method)
    {
        $route = self::removeLastSlashFromRoute($route);

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

        throw new RouteNotFoundException();
    }
}
