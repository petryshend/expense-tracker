<?php

use Symfony\Component\HttpFoundation\RedirectResponse;

unset($_SESSION['username']);

$response = new RedirectResponse('/');
$response->send();
