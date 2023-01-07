<?php

namespace Hatem\Aio\Middlewares;

class ApiMiddleware
{
    public function __invoke(){
        if(isset($_SERVER['HTTP_ACCEPT']) && ! empty($_SERVER['HTTP_ACCEPT'])){
            $headers = explode(',', $_SERVER['HTTP_ACCEPT']);
            return in_array('application/json', $headers) || in_array("*/*", $headers);
        }
        return false;
    }
}