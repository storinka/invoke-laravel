<?php

namespace Invoke\Laravel\Docs\Functions;

use Invoke\InvokeMachine;
use Invoke\Laravel\AppFunction;
use Invoke\Typesystem\Docs\ClassFunctionDocumentResult;

class DocsGetFunctionFunction extends AppFunction
{
    public static bool $secure = false;

    public static function params(): array
    {
        return [
            "name" => String(),
        ];
    }

    public static function handle(array $params): ClassFunctionDocumentResult
    {
        $functionName = $params["name"];
        $functionClass = InvokeMachine::getFunctionClass($functionName, InvokeMachine::version());

        return ClassFunctionDocumentResult::create([
            "name" => $functionName,
            "class" => $functionClass,
        ]);
    }
}
