<?php

namespace Invoke\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;
use Invoke\Laravel\Http\Controllers\InvokeController;
use Invoke\Laravel\Http\Controllers\InvokeDocsController;
use Invoke\Laravel\Services\InvokeService;

class InvokeFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return InvokeService::class;
    }

    public static function docsRoutes()
    {
        Route::get("invoke/docs/", [InvokeDocsController::class, "index"]);
        Route::get("invoke/docs/get-started/", [InvokeDocsController::class, "getStarted"]);
    }
}
