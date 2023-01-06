<?php


namespace Hatem\Aio;


use Hatem\Aio\Middlewares\AppMiddleware;

class Application
{
    public Request $request;
    public Response $response;
    public Route $route;
    public $middlwares = [];

    public function __construct()
    {
        $this->request  = new Request();
        $this->response = new Response();
        $this->route    = new Route($this->request, $this->response);
    }


    public function registerMiddlewares()
    {
        $this->middlewares = AppMiddleware::register();
    }
    public function start()
    {
        $this->route->middlewares = $this->middlewares;
        echo $this->route->resolve();
    }
}