<?php

use Invoke\Laravel\Types\RuleCustomType;
use Invoke\Typesystem\CustomTypes\InCustomType;
use Invoke\Typesystem\CustomTypes\TypedArrayCustomType;
use Invoke\Typesystem\Types;

if (!function_exists("Null")) {
    function Null($or): array
    {
        return Types::Null($or);
    }
}

if (!function_exists("Some")) {
    function Some(...$of): array
    {
        return Types::Some(...$of);
    }
}

if (!function_exists("Int")) {
    function Int(int $min = null, int $max = null)
    {
        return Types::Int($min, $max);
    }
}

if (!function_exists("Float")) {
    function Float(): string
    {
        return Types::Float;
    }
}

if (!function_exists("Bool")) {
    function Bool(): string
    {
        return Types::Bool;
    }
}

if (!function_exists("String")) {
    function String(int $minLength = null, $maxLength = null)
    {
        return Types::String($minLength, $maxLength);
    }
}

if (!function_exists("ArrayOf")) {
    function ArrayOf($type = Types::String, $minSize = null, $maxSize = null): TypedArrayCustomType
    {
        return Types::ArrayOf($type, $minSize, $maxSize);
    }
}

if (!function_exists("Regex")) {
    function Regex(string $pattern): RegexCustomType
    {
        return Types::Regex($pattern);
    }
}

if (!function_exists("Rule")) {
    function Rule($rules, $type = Types::String): RuleCustomType
    {
        return new RuleCustomType($rules, $type);
    }
}

if (!function_exists("In")) {
    function In(array $values, $type = Types::String): InCustomType
    {
        return Types::In($values, $type);
    }
}
