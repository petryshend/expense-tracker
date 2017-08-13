<?php

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

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
        $response = new RedirectResponse($generator->generate('index'));
        $response->send();
    }
}
?>

<div class="col-md-4 col-md-offset-4">
    <h3>Login to Expense Tracker</h3>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>

<div class="col-md-4 col-md-offset-4">
    <?php foreach ($errors as $error): ?>
        <div class="alert alert-danger"><?= $error; ?></div>
    <?php endforeach; ?>
</div>
