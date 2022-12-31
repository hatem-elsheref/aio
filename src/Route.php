<?php

namespace Hatem\Aio;

class Route
{
    public static $routes = [];
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    public static function get(string$path, callable|string|array $callback)
    {
        static::$routes['get'][$path] = $callback;
    }

    public static function post(string $path, callable|string|array $callback)
    {
        static::$routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $realPath = $this->request->path();
        if (str_contains($realPath, '?')){
            $realPath = explode('?', $realPath)[0];
        }

        // check if route mathed with our registered routes or not
        // first get real path parts [static words and dynamic params]
        $currentRouteSegments = $realPath == "/" ? $realPath : explode('/', trim($realPath, '/'));

        $routes = static::$routes[$this->request->method()];
        $matchedRoute = null;
        $routeParams = [];

        foreach ($routes as $route => $callback) {
            // for static routes
            if ($route == $currentRouteSegments){
                $matchedRoute = $route;
                break;
            }

            $registedRouteSegments = explode('/', trim($route, '/'));

            if (count((array) $currentRouteSegments) !== count($registedRouteSegments)){
                continue;
            }

            // get route params from registered route
            $staticSegments  = [];
            $dynamicSegments = [];

            foreach ($registedRouteSegments as $index => $segment){
                preg_match("/{[a-z0-9-_]+}/", $segment) ? $dynamicSegments[$index] = $segment : $staticSegments[$index] = $segment;
            }

            $isMatched = false;
            foreach ($staticSegments as $index => $staticSegment)
            {
                $isMatched = true;
                if ($staticSegments[$index] !== $currentRouteSegments[$index]){
                    $isMatched = false;
                    break;
                }
            }

            if ($isMatched){
                $matchedRoute = $route;
                foreach ($dynamicSegments as $index =>$dynamicSegment){
                    // use this way enforce method params must be the same names of keys
                    $routeParams[str_replace(['{', '}'], '', $dynamicSegment)] = $currentRouteSegments[$index];
                   // use this way make method params name more filexable and not neceissary to be the same name just params count = method params
                    //$routeParams[] = $currentRouteSegments[$index];
                }
            }


        }

        if (is_null($matchedRoute)){die("ERROR 404"); /*view 404*/}
        return $this->handleMatchedRoute($routes[$matchedRoute], $routeParams);

    }

    public function handleMatchedRoute(callable|string|array $callback, array $params = [])
    {

        if (is_null($callback)) return false;

       if (is_callable($callback)){
           return call_user_func($callback, $params);
       }

       if (is_array($callback)){
          return call_user_func_array([new $callback[0], $callback[1]], $params);
       }

       if (is_array($callback)){
           $parts = explode('@', $callback);
           return call_user_func_array([new $parts[0], $parts[1]], $params);
       }
    }


}