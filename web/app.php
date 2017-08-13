<?php

use DataBase\Connection;
use Expense\Repository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
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

$config = include __DIR__ . '/../app/config.php';
$connection = new Connection(
    $config['db']['driver'],
    $config['db']['host'],
    $config['db']['port'],
    $config['db']['dbname'],
    $config['db']['username'],
    $config['db']['password']
);
$expenses = new Repository($connection);

$routes = include __DIR__ . '/../app/routes.php';
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
$generator = new UrlGenerator($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include __DIR__ . '/../templates/partial/header.php';
    include sprintf(__DIR__ . '/../src/pages/%s.php', $_route);
    include __DIR__ . '/../templates/partial/footer.php';
    $response->setContent(ob_get_clean());
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not found', Response::HTTP_NOT_FOUND);
} catch (Exception $exception) {
    $response = new Response('An error occured', Response::HTTP_INTERNAL_SERVER_ERROR);
}

$response->send();
