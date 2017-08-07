<?php

use Symfony\Component\HttpFoundation\Response;

require 'bootstrap.php';

$records = $expenses->getAll();

ob_start();
include __DIR__ . '/../templates/expense_list.php';
$response = new Response(ob_get_clean());
$response->send();
