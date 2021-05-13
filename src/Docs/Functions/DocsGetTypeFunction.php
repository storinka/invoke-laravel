<?php

namespace Invoke\Laravel\Docs\Functions;

use Invoke\Laravel\LaravelFunction;
use Invoke\Typesystem\Docs\ClassTypeDocumentResult;

class DocsGetTypeFunction extends LaravelFunction
{
    public static bool $secure = false;

    public static function params(): array
    {
        return [
            "class" => String(),
        ];
    }

    public static function handle(array $params): ClassTypeDocumentResult
    {
        $class = $params["class"];
        $className = invoke_get_class_name($class);

        return ClassTypeDocumentResult::create([
            "name" => $className,
            "class" => $class,
        ]);
    }
}
