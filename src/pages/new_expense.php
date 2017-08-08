<?php

use Expense\Record;
use Symfony\Component\HttpFoundation\RedirectResponse;

$response = new RedirectResponse('/app.php/index');

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