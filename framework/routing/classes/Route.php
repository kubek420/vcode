<?php

namespace WebWork\Features;

use Closure;

class Route {
    private static $addresses = [];
    private static $methods = [];
    private static $patterns = [];
    private static $actions = [];

    private static $redirects = [];

    public static function add($method, $uri, $action) {
        // Add "/" at route beginning if it's not present
        if ($uri[0] !== '/') {
            $uri = '/'.$uri;
        }

        if (config('APP_SUBFOLDER')) {
            $uri = '/'.config('APP_SUBFOLDER').$uri;
        }

        // Check if the method is a valid HTTP method
        if (!in_array(strtoupper($method), ['GET', 'POST', 'PUT', 'PATCH', 'HEAD', 'DELETE', 'OPTIONS'])) {
            error('Method "'.$method.'" is invalid');
        }

        // Create Regex for dynamic parameters
        $pattern = preg_replace('/\{(.*?)\}/', '(.*?)', $uri).'(\\?.*?)?'; // <- Regex for query strings

        $pattern = '/^'.str_replace('/', '\/', $pattern).'$/';

        self::$addresses[$uri] = $uri;
        self::$methods[$uri] = $method;
        self::$patterns[$uri] = $pattern;
        self::$actions[$uri] = $action;
    }

    public static function get($uri, $action) {
        self::add('GET', $uri, $action);
    }

    public static function post($uri, $action) {
        self::add('POST', $uri, $action);
    }

    public static function put($uri, $action) {
        self::add('PUT', $uri, $action);
    }

    public static function patch($uri, $action) {
        self::add('PATCH', $uri, $action);
    }

    public static function head($uri, $action) {
        self::add('HEAD', $uri, $action);
    }

    public static function delete($uri, $action) {
        self::add('DELETE', $uri, $action);
    }

    public static function options($uri, $action) {
        self::add('OPTIONS', $uri, $action);
    }

    public static function evaluate() {
        // If URI requests a file, send it and return
        if (array_key_exists('extension', pathinfo($_SERVER['REQUEST_URI'])) && pathinfo($_SERVER['REQUEST_URI'])['extension']) {
            $extension = pathinfo($_SERVER['REQUEST_URI'])['extension'];
            $mimeType = 'text/plain';

            // If file doesn't exist, return 404 error
            if (!file_exists(__DIR__.'/../../../'.config('SERVER_PUBLIC_FOLDER').'/'.$_SERVER['REQUEST_URI'])) {
                abort(404);

                return;
            }

            $extensionMimeTypes = require_once __DIR__.'/../utils/content-types.php';

            if ($extension === 'php' || $_SERVER['REQUEST_URI'] === '.htaccess') {
                abort(404);

                exit;
            }

            if (array_key_exists(pathinfo($_SERVER['REQUEST_URI'])['extension'], $extensionMimeTypes)) {
                $mimeType = $extensionMimeTypes[$extension];
            }

            header('Content-Type: '.$mimeType);

            echo readfile(__DIR__.'/../../../'.config('SERVER_PUBLIC_FOLDER').'/'.$_SERVER['REQUEST_URI']);

            return;
        }

        // Check if URI matches one of registered routes
        $matchesSomeRoute = false;

        foreach (self::$addresses as $address) {
            if (preg_match(self::$patterns[$address], $_SERVER['REQUEST_URI'])) {
                $matchesSomeRoute = true;

                // Evaluate redirections


                // Check if HTTP method matches
                if (self::$methods[$address] !== strtoupper($_SERVER['REQUEST_METHOD'])) {
                    abort(404);
                }

                // Validate Recaptcha
                if (isset($_POST['g-recaptcha-response'])){
                    $captchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.config('RECAPTCHA_SECRET_KEY').'&response='.$_POST['g-recaptcha-response']);
                    $captchaValid = json_decode($captchaResponse);

                    if (!$captchaValid->success) {
                        redirectBack(['validation_error' => 'Recaptcha check failed']);
                    }
                }

                // If route has dynamic parameters, extract them
                if (preg_match('/(.*?)\{(.*?)\}(.*?)/', self::$addresses[$address])) {
                    preg_match(self::$patterns[$address], $_SERVER['REQUEST_URI'], $matches);
                }

                // If argument is anonymous function, execute it
                if (self::$actions[$address] instanceof Closure) {
                    // If "{}" are present in route, pass matched argument (closure)
                    if (isset($matches) && $matches[1]) {
                        self::$actions[$address]($matches[1]);
                    } else {
                        self::$actions[$address]();
                    }
                }

                // If argument is a string, find matching controller
                if (is_string(self::$actions[$address])) {
                    // Get route controller data
                    $controllerName = explode('@', 'App\\Controllers\\'.self::$actions[$address])[0];
                    $controllerMethod = explode('@', self::$actions[$address])[1];

                    // Check if controller class and method exists
                    if (!class_exists($controllerName)) {
                        error('Controller "'.$controllerName.'" does not exist');
                    }

                    if (!method_exists(new $controllerName(), $controllerMethod)) {
                        error('"'.$controllerName.'" doesn\'t have method called "'.$controllerMethod.'"');
                    }

                    // Create new controller instance and invoke the method
                    $controller = new $controllerName();

                    // If "{}" are present in route, pass matched argument (controller method)
                    if (isset($matches) && $matches[1]) {
                        $controller->$controllerMethod($matches[1]);
                    } else {
                        $controller->$controllerMethod();
                    }
                }

                break;
            }
        }

        if (!$matchesSomeRoute) {
            abort(404);
        }
    }

    public static function redirect($from, $to) {
        // Add "/" at route beginning if it's not present
        if ($from[0] !== '/') {
            $from = '/'.$from;
        }

        // Create Regex for dynamic parameters
        $pattern = preg_replace('/\{(.*?)\}/', '(.*?)', $from);

        $pattern = '/^'.str_replace('/', '\/', $pattern).'$/';

        self::$redirects[$from] = $to;
        self::$patterns[$from] = $pattern;
    }
}
