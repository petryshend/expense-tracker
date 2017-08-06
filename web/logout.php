<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

require 'bootstrap.php';

session_start();

unset($_SESSION['username']);

$response = new RedirectResponse('login.php');
$response->send();