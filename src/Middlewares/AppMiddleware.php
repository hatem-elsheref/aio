<?php


namespace Hatem\Aio\Middlewares;


class AppMiddleware
{

    public static function register()
    {
        return [
            'web' => [

            ],
            'api' => [
                ApiMiddleware::class,
            ],
            'auth' => [
                AuthenticatedMiddleware::class,
            ]
        ];
    }

}