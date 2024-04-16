<?php

namespace app\core\controller;

use app\exception\ApplicationException;
use app\exception\http\ApplicationHttpException;
use Exception;

class RequestHandler
{
    public static function handle(
        Request $request,
        Method $method,
        $matches,
        $middlewares
    ) {
        $container = require_once __DIR__ . "../../../config/container.php";

        try {
            foreach ($middlewares as $middleware) {
                $container->call(
                    [$middleware, "before"],
                    [$request]
                );
            }

            $response = $container->call([$method->getClass(), $method->getMethod()], array_merge([$request], $matches));

            foreach ($middlewares as $middleware) {
                $container->call(
                    [$middleware, "after"],
                    array_merge([$request], [$response])
                );
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

    private static function respondJson($message, $statusCode)
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Type: application/json');

        http_response_code($statusCode);

        return json_encode(
            [
                "data" => null,
                "message" => $message
            ]
        );
    }
}
