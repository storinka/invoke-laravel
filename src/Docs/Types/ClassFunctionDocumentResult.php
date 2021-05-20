<?php

namespace Invoke\Laravel\Docs\Types;

use Invoke\Typesystem\Docs\FunctionDocumentResult;
use Invoke\Typesystem\Type;
use Invoke\Typesystem\Typesystem;
use phpDocumentor\Reflection\DocBlockFactory;
use ReflectionClass;

class ClassFunctionDocumentResult extends FunctionDocumentResult
{
    public static function params(): array
    {
        return [
            "name" => Type::String,
            "summary" => Type::Null(Type::String),
            "description" => Type::Null(Type::String),
            "result" => Type::Null(Type::String),
            "result_type" => Type::Null(Type::T),

            "params" => Type::Null(Type::Map),
        ];
    }

    public function render(array $func): array
    {
        $name = $func["name"];
        $class = $func["class"];

        $reflection = new ReflectionClass($class);
        $docBlockFactory = DocBlockFactory::createInstance();
        $comment = $reflection->getDocComment();
        if ($comment) {
            $docblock = $docBlockFactory->create($comment);
        }

        if (!$class::resultType()) {
            $returnType = $reflection->getMethod("handle")->getReturnType();
        }

        $summary = isset($docblock) ? $docblock->getSummary() : null;
        $description = isset($docblock) ? $docblock->getDescription()->render() : null;
        if (!$class::resultType()) {
            $resultType = $returnType->getName();
            $result = isset($returnType) ? Typesystem::getTypeName($returnType->getName()) : null;
        } else {
            $resultType = $class::resultType();
            $result = Typesystem::getTypeName($class::resultType());
        }

        $params = array_map(fn($type) => Typesystem::getTypeName($type), $class::params());

        return [
            "name" => $name,
            "summary" => $summary,
            "description" => $description,
            "result" => $result,
            "result_type" => $resultType,

            "params" => $params,
        ];
    }
}
