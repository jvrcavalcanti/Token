<?php

namespace Accolon\Token;

class Token
{
    static private string $hash = "sha256";
    static private int $hour = 1;
    static private string $key;

    public static function config(string $value, int $hours = 1, string $type = "sha256"): void
    {
        self::$key = $value;
        self::$hash = $type;
        self::$hour = $hours;
    }

    public static function make($data): string
    {
        $validate = microtime(true) + (60 * 60 * self::$hour);

        $token = hash(self::$hash, self::$key) . "."
                 . base64_encode($validate) . "." 
                 . base64_encode(self::$hash) . "." 
                 . base64_encode(serialize($data) . "." . hash(self::$hash, self::$key));
        return $token;
    }
    
    public static function verify(string $hash): bool
    {
        $token = explode(".", $hash);

        if(sizeof($token) != 4) {
            return false;
        }

        if(base64_decode($token[2]) != self::$hash) {
            return false;
        }

        if(hash(self::$hash, self::$key) != $token[0]) {
            return false;
        }

        if(base64_decode($token[1]) < microtime(true)) {
            return false;
        }

        $data = explode(".", base64_decode($token[3]));

        if($data[1] != hash(self::$hash, self::$key)) {
            return false;
        }

        return true;
    }

    public static function extract(string $hash)
    {
        if(!self::verify($hash)) {
            return null;
        }

        $hash = explode(".", $hash);

        return unserialize(base64_decode($hash[3]));
    }
}