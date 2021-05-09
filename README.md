# Invoke Laravel

Invoke Laravel integration package.

## Installation

Install package via composer:

```shell
composer require storinka/invoke-laravel
```

Register routes in `routes/api.php`:

```php
use Invoke\Laravel\Facades\Invoke;

Invoke::routes();
```

## Usage

Create a function:

```php
// app/Http/Functions/Dec2Hex.php

use Invoke\Laravel\LaravelFunction;

class Dec2Hex extends LaravelFunction
{
    public static function params() : array
    {
        return [
            "dec" => Int(),
        ];
    }
    
    public function handle(int $dec): string
    {
        return dechex($dec);
    }
}
```

Register the function:

```php
// config/functions.php

use App\Http\Functions\Dec2Hex;

return [
    0 => [
        "dec2hex" => Dec2Hex::class,
    ],
];
```

Make a request to invoke the function:

```shell
curl -X POST "http://localhost:8000/api/invoke/0/dec2hex" \
  -H "Content-Type: application/json" \
  --data '{ "dec": 512 }'
```
