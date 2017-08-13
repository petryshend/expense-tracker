<?php

use DataBase\Connection;
use Expense\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

function render_template(Request $request, string $template = null): Response
{
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
    extract($request->attributes->all(), EXTR_SKIP);
    if ($template === null) {
        $template = $_route;
    }
    ob_start();
    include __DIR__ . '/../templates/partial/header.php';
    include sprintf(__DIR__ . '/../src/pages/%s.php', $template);
    include __DIR__ . '/../templates/partial/footer.php';
    return new Response(ob_get_clean());
}

$routes = new RouteCollection();
$routes->add('login', new Route('/login', [
    '_controller' => function (Request $request): Response {
        return render_template($request);
    },
]));
$routes->add('logout', new Route('/logout', [
    '_controller' => function (Request $request): Response {
        return render_template($request);
    }
]));
$routes->add('index', new Route('/', [
    '_controller' => function (Request $request): Response {
        return render_template($request);
    }
]));
$routes->add('new_expense', new Route('/new_expense', [
    '_controller' => function (Request $request): Response {
        return render_template($request);
    }
]));

return $routes;