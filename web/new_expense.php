<?php

use Expense\Record;
use Symfony\Component\HttpFoundation\RedirectResponse;

require __DIR__ . '/../vendor/autoload.php';
require 'bootstrap.php';

$response = new RedirectResponse('index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response->send();
}

$title = $_POST['new-expense-title'];
$amount = $_POST['new-expense-amount'];

if (!$title || !$amount) {
    $response->send();
}

$record = new Record(htmlentities($title), $amount);
$expenses->insert($record);

$response->send();