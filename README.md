# Invoke Laravel

Invoke with Laravel.

## Installation

1. Install the package via composer:

```shell
composer require storinka/invoke-laravel:^2
```

2. Register `InvokeProvider` in the `config/app.php`:

```php
return [
    // ...
    
    "providers" => [
        // ...
        \Invoke\Laravel\Providers\InvokeProvider::class,
    ],
    
    // ...
];
```

3. Register invoke route in the `routes/api.php`:

```php
Route::any("/invoke/{method}", \Invoke\Laravel\Http\Controllers\InvokeController::class);
```

4. Create folders for methods, data, types and validators:

```shell
mkdir app/Http/Methods \
 app/Http/Data \
 app/Http/Types \
 app/Http/Validators
```

## Usage

Create a type:

```php
// app/Http/Data/UserResult.php

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

Register the method:

```php
// config/methods.php

return [
    \App\Http\Methods\GetUserById::class,
];
```

Try to invoke:

```shell
curl 'http://localhost:8000/api/invoke/getUserById?id=1'
```

## Artisan commands

### `invoke:make:method`

Create a new method.

Example:
```shell
php artisan invoke:make:method GerUsers
```

### `invoke:make:data`

Create a new data.

Example:
```shell
php artisan invoke:make:data UserData
```

### `invoke:make:type`

Create a new type.

Example:
```shell
php artisan invoke:make:type SomeType
```

### `invoke:make:validator`

Create a new validator.

Example:
```shell
php artisan invoke:make:validator ValidEmail
```

### `invoke:make:pipe`

Create a new pipe.

Example:
```shell
php artisan invoke:make:pipe ToUpperCase
```

## Other

### Accessing Invoke

```php
$invoke = app(\Invoke\Invoke::class);

$invoke->setMethod("someMethod", SomeMethod::class);
$invoke->registeExtension(SomeExtension::class);
// etc..
```

### Set response headers

```php
$response = app(\Symfony\Component\HttpFoundation\Response::class);

$response->header('X-Some-Header', 'some value');
```