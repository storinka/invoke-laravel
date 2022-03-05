<?php

namespace Invoke\Laravel\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeData extends GeneratorCommand
{
    protected $name = "invoke:make:data";

    protected $description = "Create a new data";

    protected $type = 'Data';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Data';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Data.php.stub';
    }
}