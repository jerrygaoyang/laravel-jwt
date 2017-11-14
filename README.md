# jwt

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
    "secret" => "1234567890",           //jwt 加解密密钥
    "expire_in" => 604800,              //jwt 有效时间（单位：秒） 默认值 604800 （一周）
];
```

### User Guide



