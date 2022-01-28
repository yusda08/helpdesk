<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    const KEYJWT = 'aGVscGRlc2stYXBpaw==';

    public static function encodeJwt(array $payload): string
    {
        if (!isset($payload['exp']) || !isset($payload['iat'])) {
            $issuedAt = time();
            $expirationTime = $issuedAt + (60 * 60 * 24 * 2);
            $exp_iat = ['exp' => $expirationTime, 'iat' => $issuedAt];
            $payload = array_merge($payload, $exp_iat);
        }
        return JWT::encode($payload, static::KEYJWT, 'HS256');
    }

    public static function decodeJwt(string $jwt = ''): object|array
    {
        return JWT::decode($jwt, new Key(static::KEYJWT, 'HS256'));
//        try {
//            if (!$jwt) return [];
//        } catch (\Exception $e) {
//            return ['error' => $e->getMessage()];
//        }

    }

    public static function check(string $token): bool
    {
        try {
            $jwt = $token && self::decodeJwt($token);
            return $jwt ?: false;
        } catch (\TypeError $th) {
            return false;
        }
    }

}
