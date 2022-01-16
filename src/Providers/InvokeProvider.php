<?php

namespace Invoke\Laravel\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Invoke\Invoke;
use Invoke\Laravel\Services\InvokeService;

class InvokeProvider extends ServiceProvider
{
    public function boot()
    {
        $functions = Config::get(
            "functions",
            []
        );

        $configuration = Config::get(
            "invoke.configuration",
            [
                "typesystem" => [
                    "strict" => false,
                ],
                "ioc" => [
                    "makeFn" => fn(string $method, array $dependencies = []) => resolve($method, $dependencies),
                    "callFn" => fn($method, array $params = []) => app()->call($method, $params),
                ],
            ]
        );

        Invoke::setup($functions, $configuration);

        $this->loadViewsFrom(__DIR__ . "/../../resources/views", "invoke");
    }

    public function register()
    {
        $this->app->singleton(InvokeService::class, InvokeService::class);
    }
}
