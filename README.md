# Invoke Laravel

Invoke integration package for Laravel.

## Installation

Install package via composer:

```shell
composer require storinka/invoke-laravel:^2
```

Register routes in `routes/api.php` for Laravel:

```php
use Invoke\Laravel\Services\InvokeService;

InvokeService::routes();
```

## Usage

Create a type:

```php
// app/Http/Types/UserResult.php

use Invoke\Data;

class UserResult extends Data
{
    public int $id;
    
    public string $name;
    
    public string $email;
}
```

Create a method:

```php
// app/Http/Methods/Dec2Hex.php

use Invoke\Method;
use App\Http\Types\UserResult;

class GetUserById extends Method
{
    public int $id;
    
    protected function handle(): ?UserResult
    {
        $user = User::find($this->id);
        
        return UserResult::nullable($user);
    }
}
```

Register the function:

```php
// config/functions.php

use App\Http\Methods\GetUserById;

return [
    "getUserById" => GetUserById::class,
];
```

Make a request to invoke the function:

```shell
curl -X POST "http://localhost:8000/api/invoke/getUserById" \
  -H "Content-Type: application/json" \
  --data '{ "id": 1 }'
```

Or open in browser:

```
http://localhost:8000/api/invoke/getUserById?id=1
```

## Other

### Set response headers

```php
use Invoke\Laravel\Services\InvokeService;

$invokeService = resolve(InvokeService::class);

$invokeService->response->header('X-Some-Header', 'some value');
```