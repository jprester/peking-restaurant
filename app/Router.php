<?php

namespace App;

class Router
{
    private $routes = [];
    private $debug = false;

    public function setDebug($debug)
    {
        $this->debug = (bool) $debug;
    }

    public function get($pattern, $handler)
    {
        $this->routes[] = ['GET', $pattern, $handler];
    }

    public function post($pattern, $handler)
    {
        $this->routes[] = ['POST', $pattern, $handler];
    }

    public function put($pattern, $handler)
    {
        $this->routes[] = ['PUT', $pattern, $handler];
    }

    public function delete($pattern, $handler)
    {
        $this->routes[] = ['DELETE', $pattern, $handler];
    }

    public function resolve($method, $uri)
    {
        // Support _method override for PUT/DELETE from forms
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        // Also check X-HTTP-Method-Override header
        $override = isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']) ? $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] : null;
        if ($override) {
            $method = strtoupper($override);
        }

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

        if (strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        } else {
            $basePath = dirname($scriptName);
            if ($basePath !== '/' && $basePath !== '.' && strpos($uri, $basePath) === 0) {
                $uri = substr($uri, strlen($basePath));
            }
        }

        $uri = '/' . ltrim($uri, '/');
        $uri = parse_url($uri, PHP_URL_PATH);
        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        foreach ($this->routes as $route) {
            $routeMethod = $route[0];
            $pattern = $route[1];
            $handler = $route[2];

            if ($routeMethod !== $method) {
                continue;
            }

            // Convert route pattern to regex: {id} -> (\d+), {personCount} -> (\d+)
            $regex = preg_replace('/\{(\w+)\}/', '(\w+)', $pattern);
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches); // Remove full match
                call_user_func_array($handler, $matches);
                return;
            }
        }

        // No route matched
        http_response_code(404);
        if (strpos($uri, '/api/') === 0) {
            header('Content-Type: application/json');
            $response = ['error' => 'Not found'];
            if ($this->debug) {
                $response['debug'] = [
                    'method' => $method,
                    'uri' => $uri,
                    'script' => $_SERVER['SCRIPT_NAME']
                ];
            }
            echo json_encode($response);
        } else {
            echo "<h1>404 - Page Not Found</h1>";
            if ($this->debug) {
                echo "<p>The requested path <strong>" . htmlspecialchars($uri) . "</strong> could not be found.</p>";
                echo "<p>If you are in a subfolder, please ensure your BASE_URL is correct.</p>";
            }
        }
    }
}
