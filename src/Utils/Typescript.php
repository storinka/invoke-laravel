<?php

namespace Invoke\Laravel\Utils;

use Invoke\Docs\Types\FunctionDocumentResult;
use Invoke\Docs\Types\ParamDocumentResult;
use Invoke\Docs\Types\TypeDocumentResult;
use Invoke\InvokeMachine;
use Invoke\Typesystem\CustomTypes\TypedArrayCustomType;
use Invoke\Typesystem\InvokeType;
use Invoke\Typesystem\Types;

class Typescript
{
    public static function getStringTypeName($type): string
    {
        if (is_array($type)) {
            return implode(" | ", array_map(fn($t) => Typescript::getDocumentTypeName(TypeDocumentResult::createFromInvokeType($t)), $type));
        }

        switch ($type) {
            case Types::T:
                return "T";

            case "int":
            case "integer":
            case Types::Int:
            case "float":
            case "double":
            case Types::Float:
                return "number";

            case "string":
            case Types::String:
                return "string";

            case Types::Array:
                return "Array";

            case "bool":
            case "boolean":
            case Types::Bool:
                return "boolean";

            case null:
            case Types::Null:
                return "null";
        }

        if (is_string($type) && class_exists($type)) {
            if (is_subclass_of($type, InvokeType::class)) {
                return invoke_get_class_name($type);
            }
        }

        return $type;
    }

    public static function getDocumentTypeName(TypeDocumentResult $type): string
    {
        $typeName = Typescript::getStringTypeName($type->getType());

        if ($type->getType() instanceof TypedArrayCustomType) {
            $typeName = "Array";
        }

        if ($type->generics) {
            $generics = array_map(fn(TypeDocumentResult $typeDocument) => Typescript::getDocumentTypeName($typeDocument), $type->generics);
            $generics = implode(", ", $generics);

            return "{$typeName}<{$generics}>";
        }

        return $typeName;
    }

    public static function renderParam(ParamDocumentResult $param, $separator = ";"): string
    {
        $typeName = Typescript::getDocumentTypeName($param->type);

        $isOptional = "";

        if (is_array($actualType = $param->type->getType())) {
            if ($actualType[0] === Types::Null) {
                $isOptional = "?";
            }
        }

        return "{$param->name}{$isOptional}: {$typeName}{$separator}";
    }

    public static function renderType(TypeDocumentResult $typeDocument): string
    {
        $typeName = invoke_get_class_name($typeDocument->name);

        $text = "interface $typeName {\n";

        foreach ($typeDocument->params as $param) {
            $text .= "    " . Typescript::renderParam($param) . "\n";
        }

        $text .= "}";

        return $text;
    }

    public static function getFunctionDocument(string $functionName): FunctionDocumentResult
    {
        $version = InvokeMachine::version();
        $functionClass = InvokeMachine::getFunctionClass($functionName, $version);

        return FunctionDocumentResult::createFromInvokeFunction($functionName, $functionClass);
    }

    public static function renderFunction(FunctionDocumentResult $functionDocument): string
    {
        $functionNamePrepared = str_replace(".", "_", $functionDocument->name);

        $text = "function $functionNamePrepared(params: {\n";

        foreach ($functionDocument->params as $param) {
            $text .= "    " . Typescript::renderParam($param) . "\n";
        }

        $text .= "})";

        $text .= ": " . Typescript::getDocumentTypeName($functionDocument->result);

        $text .= " {}";

        return $text;
    }

    public static function meetParams(TypeDocumentResult $type, &$typesToRender)
    {
        if ($type->params) {
            foreach ($type->params as $param) {
                $typesToRender[] = $param->type;

                static::meetParams($param->type, $typesToRender);
            }
        }


        if ($type->generics) {
            foreach ($type->generics as $generic) {
                $typesToRender[] = $generic;

                static::meetParams($generic, $typesToRender);
            }
        }
    }

    public static function renderFunctionTypes(FunctionDocumentResult $functionDocument): string
    {
        $typesToRender = [$functionDocument->result];

        static::meetParams($functionDocument->result, $typesToRender);

        foreach ($functionDocument->params as $param) {
            $typesToRender[] = $param->type;

            static::meetParams($param->type, $typesToRender);
        }

        $renderedTypes = "";

        foreach ($typesToRender as $type) {
            if (class_exists($type->name)) {
                $renderedTypes .= Typescript::renderType($type) . "\n";
            }
        }

        return $renderedTypes;
    }
}
