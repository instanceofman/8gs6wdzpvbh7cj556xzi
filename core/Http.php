<?php

namespace Intass;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\AuthorizedException;
use App\Exceptions\UnauthenticatedException;
use Exception;

class Http
{
    protected $routes;
    protected $uri;
    protected $segments;
    protected $method;
    protected $data;
    protected $middlewares;

    public function __construct($routes)
    {
        $this->routes = $routes;

        $this->initialize();
    }

    protected function initialize()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
        $this->segments = explode('/', $this->uri);
        $this->data = json_decode(file_get_contents("php://input"), true);
    }

    protected function routeToRegex($route)
    {
        $segments = explode('/', trim($route, '/'));
        $regex = '';

        foreach ($segments as $segment) {
            if (substr($segment, 0, 1) === ':') {
                $regex .= "\/.+";
            } else {
                $regex .= $segment;
            }
        }

        return "/$regex/";
    }

    protected function matchRequest()
    {
        foreach ($this->routes as $route) {
            // Match method
            if ($route[0] !== $this->method) {
                continue;
            }

            // Match uri
            $regex = $this->routeToRegex($route[1]);

            if (preg_match($regex, $this->uri)) {
                return $route;
                break;
            }
        }

        return null;
    }

    public function segment($index)
    {
        if ($index <= 0) {
            throw new Exception("Invalid segment index");
        }

        return $this->segments[$index - 1];
    }

    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    public function hasMiddleware($middeware)
    {
        return in_array($middeware, $this->middlewares);
    }

    public function getData()
    {
        return $this->data;
    }

    public function wantJson()
    {
        return  strpos($_SERVER['HTTP_ACCEPT'], '/json') !== false
                || strpos($_SERVER['HTTP_ACCEPT'], '+json') !== false
        ;
    }

    /**
     * @return HttpResponse
     */
    public function dispatch()
    {
        $route = $this->matchRequest();

        if ($route === null) {
            return new HttpResponse('Endpoint not found', 404);
        }

        $handler = $route[2];
        $this->middlewares = isset($route[3]) ? $route[3] : [];

        list($controller, $method) = explode('@', $handler);

        // Step 3: Invoke controller's method
        require_once(APP_BASE_PATH . '/Controllers/' . $controller . '.php');

        $controllerClass = 'App\\Controllers\\'.$controller;

        try {
            $instance = new $controllerClass($this);
            return $instance->$method();
        } catch (UnauthenticatedException $exception) {
            return HttpResponse::json("Unauthenticated", 401);
        } catch (AuthorizedException $exception) {
            return HttpResponse::json("Authorized", 403);
        } catch (ModelNotFoundException $exception) {
            return HttpResponse::json("Resource not found", 404);
        } catch (\Exception $exception) {
            return HttpResponse::json("Something went wrong", 500);
        }
    }
}
