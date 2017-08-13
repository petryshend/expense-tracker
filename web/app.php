<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func($request->attributes->get('_controller'), $request);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not found', Response::HTTP_NOT_FOUND);
} catch (Exception $exception) {
    $response = new Response('An error occured', Response::HTTP_INTERNAL_SERVER_ERROR);
}

$response->send();
