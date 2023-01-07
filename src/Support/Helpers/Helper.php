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

    if (!function_exists('config')){
        function config($key = null)
        {
            $config = app()->config;
            return is_null($key) ? $config : $config->get($key);
        }
}