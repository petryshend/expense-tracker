<?php

use DataBase\Connection;
use Expense\Repository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$request = Request::createFromGlobals();

// Debug
if ($request->getClientIp() == '127.0.0.1') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if (!isset($_SESSION['username']) && $request->getBaseUrl() != '/login.php') {
    $response = new RedirectResponse('login.php');
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
