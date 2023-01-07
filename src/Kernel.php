<?php

namespace Hatem\Aio;
use Dotenv\Dotenv;

class Kernel
{
    public function register(){

        $this->loadRoutesFiles();
        Dotenv::createMutable(base_path())->load();
        // load any thing here before start application
        return $this;
    }


    private function loadRoutesFiles(){
        $routesPath = routes_path();
        foreach (glob($routesPath  . DIRECTORY_SEPARATOR . '*.php') as $file)
        {
            require_once $file;
        }
    }



}

