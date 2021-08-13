<?php

namespace Invoke\Laravel\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Invoke\InvokeMachine;
use Invoke\Laravel\Services\InvokeService;

class InvokeProvider extends ServiceProvider
{
    public function boot()
    {
        InvokeMachine::setup(Config::get("functions"), Config::get("invoke.configuration", [
            "strict" => false,
            "reflection" => true,
        ]));

        $this->loadViewsFrom(__DIR__ . "/../../resources/views", "invoke");
    }

    public function register()
    {
        $this->app->singleton("invoke", InvokeService::class);
        $this->app->singleton(InvokeService::class, InvokeService::class);
    }
}
