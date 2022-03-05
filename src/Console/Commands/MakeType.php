<?php

namespace Invoke\Laravel\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeType extends GeneratorCommand
{
    protected $name = "invoke:make:type";

    protected $description = "Create a new type";

    protected $type = 'Type';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Types';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Type.php.stub';
    }
}