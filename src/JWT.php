<?php

/**
 * Created by PhpStorm.
 * User: gaoyang
 * Date: 2017/11/8
 * Time: 13:10
 */

namespace Jerry\JWT;

use Jerry\JWT\Exceptions\TokenForwardException;
use Jerry\JWT\Exceptions\TokenExpiredException;
use Jerry\JWT\Exceptions\TokenFormatException;
use Jerry\JWT\Exceptions\PayloadFormatException;

class JWT
{

    /*
     * jwt default header only support HS256
     */
    public static function header()
    {
        return [
            "typ" => "JWT",
            'alg' => "HS256"
        ];
    }

    /*
     * basic jwt encode for HS256
     */
    public static function basic_encode($payload, $secret)
    {
        if (!is_array($payload)) {
            throw new PayloadFormatException("the payload must be array");
        }
        $header_base64 = self::safe_base64_encode(json_encode(self::header()));
        $payload_base64 = self::safe_base64_encode(json_encode($payload));
        $signature = hash_hmac("SHA256", $header_base64 . "." . $payload_base64, $secret, true);
        $signature_base64 = self::safe_base64_encode($signature);
        $token = $header_base64 . "." . $payload_base64 . "." . $signature_base64;
        return $token;
    }

    /*
     * basic jwt decode for HS256
     */
    public static function basic_decode($token, $secret)
    {
        if (!is_string($token)) {
            throw new TokenFormatException("the token is invalid");
        }
        $data = explode('.', $token);
        if (count($data) != 3) {
            throw new TokenFormatException("the token is invalid");
        }
        $header_base64 = $data[0];
        $payload_base64 = $data[1];
        $signature_base64 = $data[2];
        $signature = hash_hmac("SHA256", $header_base64 . "." . $payload_base64, $secret, true);

        if (self::safe_base64_encode($signature) == $signature_base64) {
            return json_decode(self::safe_base64_decode($payload_base64));
        } else {
            throw new TokenFormatException("the token is invalid");
        }

    }

    /*
     * base64_encode string replace '=' , '+', '-' for valid
     */
    public static function safe_base64_encode($data)
    {
        return str_replace('=', '', strtr(base64_encode($data), '+/', '-_'));
    }

    /*
     * base64_decode string to original string
     */
    public static function safe_base64_decode($base64)
    {
        $remainder = strlen($base64) % 4;
        if ($remainder) {
            $len = 4 - $remainder;
            $base64 .= str_repeat('=', $len);
        }
        return base64_decode(strtr($base64, '-_', '+/'));
    }

    /*
     * authenticate jwt expire or valid for laravel
     * and return the token for valid jwt
     */

    public static function decode($jwt)
    {
        $secret = config("jwt.secret");
        $payload = JWT::basic_decode($jwt, $secret);

        if (!array_key_exists('iat', $payload) || $payload['iat'] > time()) {
            throw new TokenForwardException('the token iat time cant not after now');
        }
        if (!array_key_exists('exp', $payload) || $payload['exp'] < time()) {
            throw new TokenExpiredException('the token exp time has expired');
        }
        return $payload;
    }

    /*
     * jwt add iat and exp attributes with laravel jwt config
     * for check jwt expired or valid
     * expire_in default 604800(s) a week
     */
    public static function encode($payload)
    {
        $secret = config("jwt.secret");
        $expire_in = config("jwt.expire_in") ? config("jwt.expire_in") : 604800;
        $iat = time();
        $exp = $iat + $expire_in;
        $payload['exp'] = $exp;
        $token = self::basic_encode($payload, $secret);
        return $token;
    }
}