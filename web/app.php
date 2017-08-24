<?php

use Simplex\ServiceContainerProvider;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$sc = ServiceContainerProvider::getServiceContainer();

$request = Request::createFromGlobals();
$response = $sc->get('framework')->handle($request);
$response->send();