<?php

namespace User;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController
{
    public function loginAction(Request $request): Response
    {
        $config = $this->getConfig();

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
                $response = new RedirectResponse('/');
                $response->send();
            }
        }

        return render_template($request, ['errors' => $errors]);
    }

    public function logoutAction(Request $request): Response
    {
        unset($_SESSION['username']);
        return new RedirectResponse('/login');
    }

    private function getConfig()
    {
        return include __DIR__ . '/../../app/config.php';
    }
}