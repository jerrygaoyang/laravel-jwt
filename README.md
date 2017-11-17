# laravel-jwt


## Installation


* First: Require this package with composer using the following command

> composer require jerrygaoyang/laravel-jwt

* Second: add the service provider to the providers array in config/app.php

> Jerry\JWT\Providers\JWTProvider::class

* Last: publish jwt config to laravel config path

> php artisan vendor:publish --provider="Jerry\JWT\Providers\JWTProvider"


## Configuration


* add the JWT middleware to the routeMiddleware array in app/Http/Kenel.php

> 'jwt' => \Jerry\JWT\Middleware\JWTMiddleware::class,

* JWT config in config/jwt.php 
```
<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2017/11/14
 * Time: 9:32
 */

return [
    "secret" => "PIe5T3xJWAMA95Uwf7pde7gmS7ZTiURg",   //jwt SHA256 signature use the secret
    "expire_in" => 604800,                            //jwt expire_in the times(seconds) , default 604800(a week)
];
```


### User Guide

##### encode and decode

```
use Jerry/JWT/JWT;

$payload = [
  "user_id" => 1
];

$token = JWT::encode($payload);
print_r($token);

echo "<br>";

$payload = JWT::decode($token);
print_r($payload);

```

##### http api process for laravel  

* First: http request must have header

``` 
{
    "Authorization": "jwt PIe5T3xJWAMA95Uwf7pde7gmS7ZTiURg"
}	
```

* Second: laravel route use middleware jwt 

```
Route::middleware(['jwt'])->group(function () {
    Route::get('/test2', 'TestController@test2');
});
```

* Last: user request get jwt decode payload in your laravel controller

```
$payload = $request->get('jwt');
```


### Exception (global for api)


you can copy below code to your Laravel app/Exceptions/handler.php render function;

it's easy to change the token exception for us;

it's easy to change the return data for api response.

of course, we should:

use Jerry\JWT\Exceptions\TokenFormatException;

use Jerry\JWT\Exceptions\TokenExpiredException;

use Jerry\JWT\Exceptions\TokenForwardException;

use Jerry\JWT\Exceptions\PayloadFormatException;

```
	if ($exception instanceof TokenFormatException) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'data' => ''
            ]);
        }
        if ($exception instanceof TokenExpiredException) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'data' => ''
            ]);
        }
        if ($exception instanceof TokenForwardException) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'data' => ''
            ]);
        }
        if ($exception instanceof PayloadFormatException) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'data' => ''
            ]);
        }
```


