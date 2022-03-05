<?php

namespace Invoke\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Invoke\Container;
use Invoke\Invoke;
use Invoke\Laravel\Internal\LaravelInvokeContainer;

class InvokeProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/invoke.php' => config_path('invoke.php'),
            __DIR__ . '/../../config/methods.php' => config_path('methods.php'),
        ]);
    }

    public function register()
    {
        /// set current Invoke container
        Container::setCurrent(new LaravelInvokeContainer());

        /// register Invoke dependency as singleton
        $this->app->singleton(Invoke::class, function () {
            return Invoke::create(
                config("methods", []),
                config("invoke", [])
            );
        });
    }
}
