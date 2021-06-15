<?php

namespace Invoke\Laravel;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Invoke\InvokeFunction;

abstract class AppFunction extends InvokeFunction
{
    public static bool $secure = true;

    public ?Authenticatable $user;

    public static function params(): array
    {
        return [];
    }

    public function __invoke(array $inputParams)
    {
        if (static::$secure) {
            $this->user = Auth::user();
        }

        return parent::__invoke($inputParams);
    }
}
