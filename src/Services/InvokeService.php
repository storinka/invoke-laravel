<?php

namespace Invoke\Laravel\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Invoke\InvokeFunction;
use Invoke\InvokeMachine;

class InvokeService
{
    public JsonResponse $response;

    public function __construct()
    {
        $this->response = new JsonResponse();
    }

    public function invoke(
        string $functionName,
        array  $params,
               $version = null
    )
    {
        $functionClass = $this->getFunctionClass($functionName, $version);

        if (function_exists($functionClass)) {
            return InvokeMachine::invokeNativeFunction($functionClass, $params);
        }

        /** @var InvokeFunction $functionInstance */
        $functionInstance = App::make($functionClass);

        return $functionInstance($params);
    }

    public function getFunctionClass(
        string $functionName,
               $version = null
    )
    {
        return InvokeMachine::getFunctionClass($functionName, $version);
    }
}
