<?php

use Invoke\Laravel\Types\RuleCustomType;
use Invoke\Typesystem\CustomTypes\RegexCustomType;
use Invoke\Typesystem\CustomTypes\TypedArrayCustomType;
use Invoke\Typesystem\Type;

function Null($or): array
{
    return Type::Null($or);
}

function Some(...$of): array
{
    return Type::Some(...$of);
}

function Int(int $min = null, int $max = null)
{
    return Type::Int($min, $max);
}

function Float(): string
{
    return Type::Float;
}

function Bool(): string
{
    return Type::Bool;
}

function String(int $minLength = null, $maxLength = null)
{
    return Type::String($minLength, $maxLength);
}

function ArrayOf($type = Type::String, $minSize = null, $maxSize = null): TypedArrayCustomType
{
    return Type::ArrayOf($type, $minSize, $maxSize);
}

function Regex(string $pattern): RegexCustomType
{
    return Type::Regex($pattern);
}

function Rule($rules): RuleCustomType
{
    return new RuleCustomType($rules);
}
