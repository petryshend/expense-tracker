<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$request = Request::createFromGlobals();
$response = new Response();

if (!isset($_SESSION['username']) && $request->getPathInfo() != '/login') {
    $response = new RedirectResponse('/login');
    $response->send();
}

$routes = include __DIR__ . '/../app/routes.php';
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);

    $response = call_user_func_array($controller, $arguments);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not found', Response::HTTP_NOT_FOUND);
} catch (Exception $exception) {
    $response = new Response('An error occured', Response::HTTP_INTERNAL_SERVER_ERROR);
}

$response->send();
