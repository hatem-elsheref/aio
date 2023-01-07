<?php

######################### PATHS ###########################
if (!function_exists('base_path')){
    function base_path()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
    }
}

if (!function_exists('config_path')){
    function config_path()
    {
        return base_path() . DIRECTORY_SEPARATOR . 'config';
    }
}


if (!function_exists('public_path')){
    function public_path()
    {
        return base_path() . DIRECTORY_SEPARATOR . 'public';
    }
}


if (!function_exists('views_path')){
    function views_path()
    {
        return base_path() . DIRECTORY_SEPARATOR . 'views';
    }
}


if (!function_exists('routes_path')){
    function routes_path()
    {
        return base_path() . DIRECTORY_SEPARATOR . 'routes';
    }
}

if (!function_exists('app_path')){
    function app_path()
    {
        return base_path() . DIRECTORY_SEPARATOR . 'App';
    }
}

if (!function_exists('database_path')){
    function database_path()
    {
        return base_path() . DIRECTORY_SEPARATOR . 'database';
    }
}
######################### BASE ###########################
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

if (!function_exists('env')){
    function env($key, $default)
    {
        return isset($_ENV[$key]) ? $_ENV[$key] : $default;
    }
}

if (!function_exists('dd')){
    function dd(...$items)
    {
        echo '<pre>';
        var_dump($items);
        exit(0);
    }
}

