<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();
$routes->add('register', new Route('/register', [
    '_controller' => 'User\LoginController::registerAction'
]));
$routes->add('login', new Route('/login', [
    '_controller' => 'User\LoginController::loginAction'
]));
$routes->add('logout', new Route('/logout', [
    '_controller' => 'User\LoginController::logoutAction'
]));
$routes->add('index', new Route('/', [
    '_controller' => 'Expense\ExpenseController::indexAction',
]));
$routes->add('all_records', new Route('/all', [
    '_controller' => 'Expense\ExpenseController::allRecordsAction',
]));
$routes->add('new_expense', new Route('/new_expense', [
    '_controller' => 'Expense\ExpenseController::newExpenseAction'
]));

$routes->add('api_expenses', new Route('/api/expenses', [
    '_controller' => 'Api\ExpenseController::expensesAction',
]));

return $routes;