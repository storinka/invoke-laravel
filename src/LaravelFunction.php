<?php

namespace Invoke\Laravel;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Invoke\InvokeError;
use Invoke\InvokeFunction;

abstract class LaravelFunction extends InvokeFunction
{
    public static bool $secure = true;

    public ?Authenticatable $user;

    public static function params(): array
    {
        return [];
    }

    public function invoke(array $inputParams)
    {
        if (static::$secure) {
            if (!Auth::check()) {
                throw new InvokeError("UNAUTHORIZED", "Unauthorized.", 401);
            }

            $this->user = Auth::user();
        }

        return parent::invoke($inputParams);
    }
}
