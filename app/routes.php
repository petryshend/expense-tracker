<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

function render_template(Request $request, $arguments = [], string $template = null): Response
{
    extract($request->attributes->all(), EXTR_SKIP);
    extract($arguments, EXTR_SKIP);
    if ($template === null) {
        $template = $_route;
    }
    ob_start();
    include __DIR__ . '/../src/templates/partial/header.php';
    include sprintf(__DIR__ . '/../src/templates/%s.php', $template);
    include __DIR__ . '/../src/templates/partial/footer.php';
    return new Response(ob_get_clean());
}

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