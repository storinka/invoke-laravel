<?php

namespace Invoke\Laravel\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeMethod extends GeneratorCommand
{
    protected $name = "invoke:make:method";

    protected $description = "Create a new method";

    protected $type = 'Method';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Methods';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Method.php.stub';
    }
}