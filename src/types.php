<?php

use Invoke\Laravel\Types\RuleCustomType;
use Invoke\Typesystem\CustomTypes\InArrayCustomType;
use Invoke\Typesystem\CustomTypes\RegexCustomType;
use Invoke\Typesystem\CustomTypes\TypedArrayCustomType;
use Invoke\Typesystem\Type;

if (!function_exists("Null")) {
    function Null($or): array
    {
        return Type::Null($or);
    }
}

if (!function_exists("Some")) {
    function Some(...$of): array
    {
        return Type::Some(...$of);
    }
}

if (!function_exists("Int")) {
    function Int(int $min = null, int $max = null)
    {
        return Type::Int($min, $max);
    }
}

if (!function_exists("Float")) {
    function Float(): string
    {
        return Type::Float;
    }
}

if (!function_exists("Bool")) {
    function Bool(): string
    {
        return Type::Bool;
    }
}

if (!function_exists("String")) {
    function String(int $minLength = null, $maxLength = null)
    {
        return Type::String($minLength, $maxLength);
    }
}

if (!function_exists("ArrayOf")) {
    function ArrayOf($type = Type::String, $minSize = null, $maxSize = null): TypedArrayCustomType
    {
        return Type::ArrayOf($type, $minSize, $maxSize);
    }
}

if (!function_exists("Regex")) {
    function Regex(string $pattern): RegexCustomType
    {
        return Type::Regex($pattern);
    }
}

if (!function_exists("Rule")) {
    function Rule($rules, $type = Type::String): RuleCustomType
    {
        return new RuleCustomType($rules, $type);
    }
}

if (!function_exists("In")) {
    function In(array $values, $type = Type::String): InArrayCustomType
    {
        return Type::In($values, $type);
    }
}
