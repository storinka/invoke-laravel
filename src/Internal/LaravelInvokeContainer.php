<?php

namespace Invoke\Laravel\Internal;

use Invoke\Container\InvokeContainerInterface;

/**
 * Laravel container wrapper for Invoke container. It means that Invoke container will use Laravel container to resolve dependencies.
 */
class LaravelInvokeContainer implements InvokeContainerInterface
{
    /**
     * @inheritDoc
     */
    public function get(string $id)
    {
        return app()->get($id);
    }

    /**
     * @inheritDoc
     */
    public function has(string $id): bool
    {
        return app()->has($id);
    }

    /**
     * @inheritDoc
     */
    public function factory(string $id, callable|string|null $factory = null): void
    {
        app()->bind($id, $factory);
    }

    /**
     * @inheritDoc
     */
    public function singleton(string $id, callable|object|string|null $singleton = null): void
    {
        if (is_object($singleton)) {
            app()->instance($id, $singleton);
        } else {
            app()->singleton($id, $singleton);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(string $id): void
    {
        app()->forgetInstance($id);
    }

    /**
     * @inheritDoc
     */
    public function make(callable|string $classOrCallable, array $parameters = []): mixed
    {
        return app()->make($classOrCallable, $parameters);
    }
}
