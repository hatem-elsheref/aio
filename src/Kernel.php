<?php

namespace Hatem\Aio;
use Dotenv\Dotenv;

class Kernel
{
    public $middlewares = [];
    public function register(){

        $this->loadRoutesFiles();
        $this->loadConfigurationsFiles();
        Dotenv::createMutable(__DIR__ . DIRECTORY_SEPARATOR . '..')->load();
        // load any thing here before start application
        return $this;
    }


    private function loadRoutesFiles(){
        $routesPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'routes';
        foreach (glob($routesPath  . DIRECTORY_SEPARATOR . '*.php') as $file)
        {
            require_once $file;
        }
    }

    private function loadConfigurationsFiles(){
        $configPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config';
        foreach (glob($configPath  . DIRECTORY_SEPARATOR . '*.php') as $file)
        {
            require_once $file;
        }
    }

}

