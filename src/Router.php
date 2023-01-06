<?php


namespace Hatem\Aio;


class Router
{
    public $path        = [];
    public $middlewares = [];
    public $name        = null;


    public function get(string $path, callable|string|array $callback)
    {
        $this->path['path']     = $path;
        $this->path['callback'] = $callback;
        return $this;
    }

    public function post(string $path, callable|string|array $callback)
    {
        $this->path['path']     = $path;
        $this->path['callback'] = $callback;
        return $this;
    }
    public function middleware(string|array $names)
    {
        foreach((array)$names as $name){
            $this->middlewares[] = $name;
        }
        return $this;
    }

  public function name(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function prefix(string $prefix)
    {
        $this->path['prefix'] = $prefix;
        return $this;
    }
}