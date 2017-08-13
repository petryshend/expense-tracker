<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('login', new Route('/login'));
$routes->add('logout', new Route('/logout'));
$routes->add('index', new Route('/'));
$routes->add('new_expense', new Route('/new_expense'));

return $routes;