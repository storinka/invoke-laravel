<?php

namespace Invoke\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;
use Invoke\Laravel\Http\Controllers\InvokeController;
use Invoke\Laravel\Http\Controllers\InvokeDocsController;
use Invoke\Laravel\Services\InvokeService;

/**
 * @method static invoke(string $functionName, array $params, ?int $version = null)
 * @method static getFunctionClass(string $functionName, ?int $version = null)
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

    public static function docsRoutes()
    {
        Route::get("invoke/docs/", [InvokeDocsController::class, "index"])->name("invoke-docs");
        Route::get("invoke/docs/get-started/", [InvokeDocsController::class, "getStarted"])->name("invoke-docs-getstarted");
    }

    public static function lumenRoutes()
    {
        Route::get("invoke/{functionName}", "InvokeController@invoke");
        Route::post("invoke/{functionName}", "InvokeController@invoke");
        Route::get("invoke/{version}/{functionName}", "InvokeController@invokeWithVersion");
        Route::post("invoke/{version}/{functionName}", "InvokeController@invokeWithVersion");
    }

    public static function lumenDocsRoutes()
    {
        Route::get("invoke/docs/", "InvokeDocsController@index")->name("invoke-docs");
        Route::get("invoke/docs/get-started/", "InvokeDocsController@getStarted")->name("invoke-docs-getstarted");
    }
}
