<?php


namespace Hatem\Aio\Support;


class Config
{
    public static $data = [];
    const KEY_NOT_FOUND = 777555;

    public function __construct($path = null)
    {
        if (!is_null($path)){
            foreach (glob($path  . DIRECTORY_SEPARATOR . '*.php') as $file)
            {
                $this->readFromArray($file);
            }
            foreach (glob($path  . DIRECTORY_SEPARATOR . '*.json') as $file)
            {
                $this->readFromJson($file);
            }
        }
    }

    public function get($key, $default = null)
    {
       $container = $this->nestedContainer($key);
       if ($container === self::KEY_NOT_FOUND)
           return $default;
       else
           return $container;
    }

    public function set($key, $value)
    {
        $segments = explode('.', $key);
        $currentContainer = &self::$data;
        foreach ($segments as $index => $segment){
            if(isset($currentContainer[$segment])){
                $currentContainer = &$currentContainer[$segment];
            }else{
                $currentContainer[$segment] = $value;
            }
        }
    }

    public function has(string $key)
    {
        return $this->nestedContainer($key) === self::KEY_NOT_FOUND ? false : true;
    }

    private function nestedContainer(string $key)
    {
        $segments = explode('.', $key);
        $currentContainer = self::$data;
        foreach ($segments as $index => $segment){
            if(isset($currentContainer[$segment])){
                $currentContainer = $currentContainer[$segment];
            }else{
                return self::KEY_NOT_FOUND;
            }
        }
        return $currentContainer;
    }

    private function readFromArray(string $file)
    {
        if (is_file($file) && file_exists($file))
            self::$data[pathinfo($file, PATHINFO_FILENAME)] = require_once $file;
    }

    private function readFromJson(string $file)
    {
        if (is_file($file) && file_exists($file))
            self::$data[pathinfo($file, PATHINFO_FILENAME)] =
                array_merge(self::$data[pathinfo($file, PATHINFO_FILENAME)], json_decode(file_get_contents($file), true));
    }

}