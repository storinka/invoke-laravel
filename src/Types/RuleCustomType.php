<?php

namespace Invoke\Laravel\Types;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Invoke\Typesystem\CustomType;
use Invoke\Typesystem\Exceptions\InvalidParamValueException;
use Invoke\Typesystem\Type;

class RuleCustomType extends CustomType
{
    protected $rules;

    public function __construct($rules, $type = Type::String)
    {
        $this->rules = $rules;

        $this->type = $type;
    }

    public function validate(string $paramName, $value)
    {
        try {
            Validator::validate([
                $paramName => $value,
            ], [
                $paramName => $this->rules,
            ]);
        } catch (ValidationException $exception) {
            throw new InvalidParamValueException(
                $paramName,
                $this,
                $value,
                $exception->errors()[$paramName][0],
            );
        }

        return $value;
    }
}
