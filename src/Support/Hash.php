<?php


namespace Hatem\Aio\Support;


class Hash
{
    public static function make($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public static function verify($value, $hashed){
        return password_verify($value, $hashed);
    }

    public static function hash($value){
        return sha1($value);
    }
}