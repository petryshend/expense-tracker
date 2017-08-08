<?php

use DataBase\Connection;
use Expense\Repository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$request = Request::createFromGlobals();
$response = new Response();

// Debug
if ($request->getClientIp() == '127.0.0.1') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

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

$map = [
    '/login' => __DIR__ . '/../src/pages/login.php',
    '/logout' => __DIR__ . '/../src/pages/logout.php',
    '/index' => __DIR__ . '/../src/pages/index.php',
    '/' => __DIR__ . '/../src/pages/index.php',
    '/new_expense' => __DIR__ . '/../src/pages/new_expense.php',
];

$path = $request->getPathInfo();
if (isset($map[$path])) {
    ob_start();
    include __DIR__ . '/../templates/partial/header.php';
    include $map[$path];
    include __DIR__ . '/../templates/partial/footer.php';
    $response->setContent(ob_get_clean());
} else {
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
    $response->setContent('Not found');
}

$response->send();
