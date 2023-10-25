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

        $this->addRoute("getCurrentDateTime", "app\\controller\\http\\API\\ExampleController", "getCurrentDateTime", false, false, null);
    }

    public function addRoute($route, $class, $method, $needsAuth, $needsPermission, $codePermission = null)
    {
        if (!array_key_exists($route, self::$routes)) {
            self::$routes[$route] = new Method($class, $method, $needsAuth, $needsPermission, $codePermission);
        }
    }

    public function addMiddleware($route, $middleware)
    {
        if (!array_key_exists($route, self::$middlewares)) {
            self::$middlewares[$route] = [];
        }
        self::$middlewares[$route][] = $middleware;
    }

    public function run($post, $route)
    {
        if (array_key_exists($route, self::$routes)) {
            $method = self::$routes[$route];

            $middlewares = $this->getMiddlewaresForRoute($route);
            foreach ($middlewares as $middleware) {
                $middleware->before($post);
            }

            $allowedRequest = !$method->getNeedsAuth();
            if ($method->getNeedsAuth() && (isset($_SESSION["user_is_logged"]) && $_SESSION["user_is_logged"])) {
                $allowedRequest = true;
            }

            if (!$method->authorize()) {
                http_response_code(403);
                return "Permission denied";
            }

            if ($allowedRequest) {
                $container = require_once __DIR__ . "../../../config/container.php";

                try {
                    $response = $container->call([self::$routes[$route]->getClass(), self::$routes[$route]->getMethod()], array($post));;

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
            } else {
                http_response_code(405);
                return "Permission error";
            }
        }

        http_response_code(404);
        return "Route not found";
    }

    private function getMiddlewaresForRoute($route)
    {
        return self::$middlewares[$route] ?? [];
    }
}

class Method
{
    private $class;
    private $method;
    private $needsAuth;
    private $needsPermission;
    private $codePermission;

    public function __construct($class, $method, $needsAuth, $needsPermission, $codePermission)
    {
        $this->class = $class;
        $this->method = $method;
        $this->needsAuth = $needsAuth;
        $this->needsPermission = $needsPermission;
        $this->codePermission = $codePermission;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getNeedsAuth()
    {
        return $this->needsAuth;
    }

    public function getNeedsPermission()
    {
        return $this->needsPermission;
    }

    public function getCodePermission()
    {
        return $this->codePermission;
    }

    public function authorize()
    {
        $allowed = !$this->getNeedsPermission();
        if ($this->getNeedsPermission() && isset($_SESSION['permissions'][$this->getCodePermission()])) {
            return true;
        }

        return $allowed;
    }
}
