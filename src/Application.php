<?php


namespace Hatem\Aio;


use Hatem\Aio\Middlewares\AppMiddleware;
use Hatem\Aio\Support\Config;

class Application
{
    public Request $request;
    public Response $response;
    public Route $route;
    public Config $config;

    public $middlwares = [];

    public function __construct()
    {
        $this->request  = new Request();
        $this->response = new Response();
        $this->route    = new Route($this->request, $this->response);
        $this->config   = new Config(config_path());
    }


    public function registerMiddlewares()
    {
        $this->middlwares = AppMiddleware::register();
    }
    public function start()
    {
        $this->route->middlewares = $this->middlwares;
        echo $this->route->resolve();
    }
}