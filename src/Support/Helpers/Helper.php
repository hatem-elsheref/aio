<?php

if (!function_exists('app')){
    function app()
    {
        static $instance = null;
        if (is_null($instance)){
            $instance = new \Hatem\Aio\Application();
        }

        return $instance;
    }
}