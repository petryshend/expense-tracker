<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('login', new Route('/login', [
    '_controller' => 'User\LoginController::loginAction'
]));
$routes->add('logout', new Route('/logout', [
    '_controller' => 'User\LoginController::logoutAction'
]));
$routes->add('index', new Route('/', [
    '_controller' => 'Expense\ExpenseController::indexAction',
]));
$routes->add('new_expense', new Route('/new_expense', [
    '_controller' => 'Expense\ExpenseController::newExpenseAction'
]));

return $routes;