<?php

namespace Invoke\Laravel\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakePipe extends GeneratorCommand
{
    protected $name = "invoke:make:pipe";

    protected $description = "Create a new pipe";

    protected $type = 'Pipe';

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Pipes';
    }

    protected function getStub(): string
    {
        return __DIR__ . '/stubs/Pipe.php.stub';
    }
}