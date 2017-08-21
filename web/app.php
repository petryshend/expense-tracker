<?php

use Simplex\ResponseListener;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$request = Request::createFromGlobals();
$response = new Response();

$routes = include __DIR__ . '/../app/routes.php';
$context = new RequestContext();
$matcher = new UrlMatcher($routes, $context);

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new ResponseListener());

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$framework = new \Simplex\Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();
