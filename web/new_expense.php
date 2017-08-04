<?php

use Expense\Record;

require __DIR__ . '/../vendor/autoload.php';
require 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
}

$title = $_POST['new-expense-title'];
$amount = $_POST['new-expense-amount'];

if (!$title || !$amount) {
    header('Location: index.php');
}

$record = new Record($title, $amount);
$expenses->insert($record);

header('Location: index.php');