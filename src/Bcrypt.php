<?php

namespace Accolon\Token;

class Bcrypt
{
    public static function make(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, [
            "cost" => 8
        ]);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}