<?php

namespace Core;

class Router
{
    private $routes = [];

    // Add route with optional middleware
    public function add($method, $path, $action)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'action' => $action,
            'middleware' => null, // Default middleware is null
        ];
        return $this; // Enable chaining for middleware
    }

    // Attach middleware to the last added route
    public function middleware($middleware)
    {
        $lastIndex = count($this->routes) - 1;

        if ($lastIndex >= 0) {
            $this->routes[$lastIndex]['middleware'] = $middleware;
        }

        return $this; // Enable further chaining
    }

    // Handle the incoming request
    public function handleRequest()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        // Dynamically extract the base path (like /custom_structure)
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

        // Remove the base path from the URI
        $uri = str_replace($basePath, '', $uri);

        // Remove query string from the URI
        $uri = strtok($uri, '?');

        // Find the matching route
        $foundRoute = false;

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $foundRoute = true;

                // Execute middleware if attached
                if ($route['middleware']) {
                    $middlewareClass = 'App\\Middleware\\' . ucfirst($route['middleware']);
                    if (class_exists($middlewareClass)) {
                        $middleware = new $middlewareClass();
                        $middleware->handle(); // Execute middleware logic
                    } else {
                        echo "Middleware '{$route['middleware']}' not found.";
                        exit;
                    }
                }

                // Call the controller action
                try {
                    $this->callAction($route['action']);
                } catch (\Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
            }
        }

        // If no route is found
        if (!$foundRoute) {
            require_once base_path("app/Views/404.view.php"); // Load the 404 view
        }
    }


    private function callAction($action)
    {
        list($controllerName, $methodName) = explode('@', $action);
        $controller = 'App\\Controllers\\' . $controllerName;

        if (!class_exists($controller)) {
            throw new \Exception("Controller '{$controllerName}' not found.");
        }

        $controllerObj = new $controller();

        if (!method_exists($controllerObj, $methodName)) {
            throw new \Exception("Method '{$methodName}' not found in controller '{$controllerName}'.");
        }

        $controllerObj->$methodName();
    }
}
