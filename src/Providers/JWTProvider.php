<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2017/11/14
 * Time: 9:29
 */

namespace Jerry\JWT\Providers;

use Illuminate\Support\ServiceProvider;


class JWTProvider extends ServiceProvider
{
    /*
     * publish jwt config file to laravel config path
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/jwt.php' => config_path('jwt.php')
        ]);
    }
}