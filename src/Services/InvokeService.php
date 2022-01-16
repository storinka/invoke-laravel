<?php

namespace Invoke\Laravel\Services;

use Illuminate\Http\JsonResponse;
use Invoke\Invoke;
use Invoke\Laravel\Http\Controllers\InvokeController;

class InvokeService
{
    public JsonResponse $response;

    public function __construct()
    {
        $this->response = new JsonResponse();
    }

    public function invoke(string $name,
                           array  $params)
    {
        return Invoke::invoke($name, $params);
    }

    public function getMethod(string $name)
    {
        return Invoke::getMethod($name);
    }

    public static function routes()
    {
        Route::any("invoke/{method}", [InvokeController::class, "invoke"]);
    }
}
