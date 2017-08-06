<?php

use DataBase\Connection;
use Expense\Repository;
use Symfony\Component\HttpFoundation\Response;

require 'bootstrap.php';

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

$records = $expenses->getAll();

ob_start();
include __DIR__ . '/../templates/expense_list.php';
$response = new Response(ob_get_clean());
$response->send();
