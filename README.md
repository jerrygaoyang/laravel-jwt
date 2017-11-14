# laravel-jwt

### Installation

* First: Require this package with composer using the following command

> composer require jerrygaoyang/laravel-jwt

* Second: add the service provider to the providers array in config/app.php

> Jerry\JWT\Providers\JWTProvider::class

* Last: publish jwt config to laravel config path

> php artisan vendor:publish --provider="Jerry\JWT\Providers\JWTProvider"

### Configuration

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



