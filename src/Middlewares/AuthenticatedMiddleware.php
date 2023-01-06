<?php


namespace Hatem\Aio\Middlewares;


class AuthenticatedMiddleware
{
    public function __invoke($next = true)
    {
        if(!isset($_SESSION['USER_ID'])){
            return false;
        }

        return $next;
    }
}