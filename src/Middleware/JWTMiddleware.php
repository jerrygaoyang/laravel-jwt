<?php
/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2017/11/13
 * Time: 17:05
 */

namespace Jerry\JWT\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Jerry\JWT\JWT;
use Jerry\JWT\Exceptions\TokenFormatException;


class JWTMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            throw new TokenFormatException('the request has no the header for Authorization');
        }
        try {
            $authorization = $request->header('Authorization');
            $jwt = substr($authorization, 4, strlen($authorization));
            $payload = JWT::decode($jwt);
            $request->attributes->add(['jwt' => $payload]);
        } catch (Exception $e) {
            throw new TokenFormatException('the request jwt is error format or invalid');
        }
        return $next($request);
    }
}