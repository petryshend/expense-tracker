<?php

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

