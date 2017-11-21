<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2017/11/14
 * Time: 9:29
 */

namespace Jerry\JWT\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;


class JWTProvider extends ServiceProvider
{
    /*
     * publish jwt config file to laravel config path
     */
    public function boot()
    {
        if (!file_exists(config_path('jwt.php'))) {
            $this->publishes([
                __DIR__ . '/../Config/jwt.php' => config_path('jwt.php')
            ]);
            $content = file_get_contents(__DIR__ . '/../Config/jwt.php');
            $laravel = 'jerrygaoyanglaraveljwtlaraveljwt';
            $secret = Str::random(32);
            file_put_contents(config_path('jwt.php'), str_replace($laravel, $secret, $content));
        }
    }
}
