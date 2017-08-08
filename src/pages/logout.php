<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

unset($_SESSION['username']);

$response = new RedirectResponse('app.php/login');
$response->send();
