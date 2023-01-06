<?php

namespace Hatem\Aio;

class Route
{
    public static $routes = [];
    public $middlewares = [];
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

//    public static function middleware(array|string $middlewares)
//    {
//        $router = new Router();
//        foreach((array)$middlewares as $middleware){
//         $router->middleware[] = $middleware;
//        }
//        static::$routes['get'][] = $router;
//        return $router;
//    }
//    public static function prefix(string $prefix)
//    {
//        $router = new Router();
//        $router->path['prefix'] = $prefix;
//        static::$routes['get'][] = $router;
//        return $router;
//    }
    public static function get(string $path, callable|string|array $callback)
    {
        $router = new Router();
        $router->get($path, $callback);
        static::$routes['get'][] = $router;
        return $router;
    }


    public static function post(string $path, callable|string|array $callback)
    {
        $router = new Router();
        $router->get($path, $callback);
        static::$routes['post'][] = $router;
        return $router;
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

        foreach ($routes as $routeIndex => $route) {
            // for static routes
            $route = isset($route->path['prefix']) ? "/" . trim($route->path['prefix'], '/') . '/' . trim($route->path['path'], '/') : $route->path['path'];
            if ($route == $currentRouteSegments){
                $matchedRoute = $route;
                $matchedIndex = $routeIndex;
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
                $matchedIndex = $routeIndex;
                foreach ($dynamicSegments as $index =>$dynamicSegment){
                    // use this way enforce method params must be the same names of keys
                    $routeParams[str_replace(['{', '}'], '', $dynamicSegment)] = $currentRouteSegments[$index];
                    // use this way make method params name more filexable and not neceissary to be the same name just params count = method params
                    //$routeParams[] = $currentRouteSegments[$index];
                }
            }
        }

        if (is_null($matchedRoute)){die("ERROR 404"); /*view 404*/}
        return $this->handleMatchedRoute($routes[$routeIndex]->path['callback'], $routes[$routeIndex]->middlewares, $routeParams);
    }


    public function handleMatchedRoute(callable|string|array $callback, array $middlewareNames = [], array $params = [])
    {

        if (is_null($callback)) return 'No Callback Or Controller To Handle This Route';

        foreach($middlewareNames as $middlewareName){
            foreach($this->middlewares[$middlewareName] as $middleware){
                $middlewareObj = new $middleware();
                $response = $middlewareObj();
                if(!$response){
                    return 'Not Allowed!';
                }
            }
        }

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