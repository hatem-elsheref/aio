<?php


namespace Hatem\Aio;


class Application
{
    public Request $request;
    public Response $response;
    public Route $route;

    public function __construct()
    {
        $this->request  = new Request();
        $this->response = new Response();
        $this->route    = new Route($this->request, $this->response);
    }

    public function start()
    {
        echo $this->route->resolve();
    }
}