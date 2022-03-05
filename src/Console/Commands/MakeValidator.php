<?php

namespace Invoke\Laravel\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeValidator extends GeneratorCommand
{
    protected $name = "invoke:make:validator";

    protected $description = "Create a new validator";

    protected $type = 'Validator';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Validators';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Validator.php.stub';
    }
}