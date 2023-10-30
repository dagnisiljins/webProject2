<?php

use App\Controllers\SiteController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

$loader = new FilesystemLoader(__DIR__ . '/app/templates');
$twig = new Environment($loader);

$controller = new SiteController($twig);

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) use ($controller) {
    $router->addRoute('GET', '/', [$controller, 'index']);
    $router->addRoute('GET', "/article/{id:\d+}", [$controller, 'article']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $vars = $routeInfo[2];

        [$controller, $method] = $routeInfo[1];

        $response = $controller->{$method}($vars);

        echo $response;

        break;
}
