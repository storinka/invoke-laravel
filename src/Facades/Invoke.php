<?php

namespace Invoke\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;
use Invoke\Laravel\Http\Controllers\InvokeController;
use Invoke\Laravel\Services\InvokeService;

/**
 * @method invoke(string $functionName, array $params, ?int $version = null)
 */
class Invoke extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return InvokeService::class;
    }

    public static function routes()
    {
        Route::any("invoke/{functionName}", [InvokeController::class, "invoke"]);
        Route::any("invoke/{version}/{functionName}", [InvokeController::class, "invokeWithVersion"]);
    }
}
