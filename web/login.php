<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

require 'bootstrap.php';

$config = include __DIR__ . '/../app/config.php';

/** @var Request $request */

$errors = [];
$validUsername = false;
$username = $request->get('username');
$password = $request->get('password');
if ($request->isMethod(Request::METHOD_POST)) {
    if (!$username) {
        $errors[] = 'You must enter username';
    } else {
        if ($username !== $config['login']['username']) {
            $errors[] = 'Username is wrong';
        } else {
            $validUsername = true;
        }
    }
    $validPassword = false;
    if (!$password) {
        $errors[] = 'You must enter password';;
    } else {
        if ($password !== $config['login']['password']) {
            $errors[] = 'Password is wrong';
        } else {
            $validPassword = true;
        }
    }

    if ($validUsername && $validPassword) {
        $_SESSION['username'] = $username;
        $response = new RedirectResponse('index.php');
        $response->send();
    }
}

include __DIR__ . '/../templates/login.php';


