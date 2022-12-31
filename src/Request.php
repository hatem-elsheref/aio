<?php


namespace Hatem\Aio;
use Hatem\Aio\Support\Str;

class Request
{
    public function method()
    {
        return Str::lower($_SERVER['REQUEST_METHOD']);
    }

    public function path()
    {
        return $_SERVER['REQUEST_URI'];
    }
}