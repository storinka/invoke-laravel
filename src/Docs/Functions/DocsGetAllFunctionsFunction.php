<?php

namespace Invoke\Laravel\Docs\Functions;

use Invoke\InvokeMachine;
use Invoke\Laravel\AppFunction;
use Invoke\Typesystem\CustomTypes\TypedArrayCustomType;
use Invoke\Typesystem\Docs\ClassFunctionDocumentResult;

class DocsGetAllFunctionsFunction extends AppFunction
{
    public static bool $secure = false;

    public static function resultType(): ?TypedArrayCustomType
    {
        return ArrayOf(ClassFunctionDocumentResult::class);
    }

    public static function handle(): array
    {
        $functions = [];

        $functionsTree = InvokeMachine::currentVersionFunctionsTree();

        foreach ($functionsTree as $name => $class) {
            $functions[$name] = ClassFunctionDocumentResult::create([
                "name" => $name,
                "class" => $class,
            ]);
        }

        return $functions;
    }
}
