<?php

namespace User;

use Simplex\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends BaseController
{
    public function loginAction(Request $request): Response
    {
        $errors = [];
        $validUsername = false;
        $username = $request->get('username');
        $password = $request->get('password');
        if ($request->isMethod(Request::METHOD_POST)) {
            if (!$username) {
                $errors['username'] = 'You must enter username';
            } else {
                if ($username !== $this->getParameter('login.username')) {
                    $errors['username'] = 'Username is wrong';
                } else {
                    $validUsername = true;
                }
            }
            $validPassword = false;
            if (!$password) {
                $errors['password'] = 'You must enter password';;
            } else {
                if ($password !== $this->getParameter('login.password')) {
                    $errors['password'] = 'Password is wrong';
                } else {
                    $validPassword = true;
                }
            }

            if ($validUsername && $validPassword) {
                $_SESSION['username'] = $username;
                $response = new RedirectResponse('/');
                $response->send();
            }
        }

        return $this->render('login', ['errors' => $errors]);
    }

    public function logoutAction(): Response
    {
        unset($_SESSION['username']);
        return new RedirectResponse('/login');
    }
}