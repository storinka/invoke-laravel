<?php

namespace Invoke\Laravel\Services;

use Illuminate\Support\Facades\App;
use Invoke\InvokeFunction;
use Invoke\InvokeMachine;

class InvokeService
{
    public function invoke(
        string $functionName,
        array $params,
        ?int $version = null
    )
    {
        $functionClass = InvokeMachine::getFunctionClass($functionName, $version);

        /** @var InvokeFunction $functionInstance */
        $functionInstance = App::make($functionClass);

        return $functionInstance->invoke($params);
    }
}
