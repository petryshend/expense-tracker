<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

unset($_SESSION['username']);

$response = new RedirectResponse('front.php/login');
$response->send();
