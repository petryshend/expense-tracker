<?php

namespace Expense;

use DataBase\Connection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController
{
    private $expenses;

    public function __construct()
    {
        $config = $this->getConfig();
        $connection = new Connection(
            $config['db']['driver'],
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['dbname'],
            $config['db']['username'],
            $config['db']['password']
        );
        $this->expenses = new Repository($connection);
    }

    public function indexAction(Request $request): Response
    {
        return render_template($request, ['records' => $this->expenses->getAll()]);
    }

    public function newExpenseAction(Request $request): Response
    {
        if (!$request->isMethod('post')) {
            return new RedirectResponse('/');
        }

        $title = $request->get('new-expense-title');
        $amount = $request->get('new-expense-amount');

        if (!$title || !$amount) {
            return new RedirectResponse('/');
        }

        $record = new Record($title, $amount);
        $this->expenses->insert($record);

        return new RedirectResponse('/');
    }

    public function helloAction(Request $request, string $name): Response
    {
        return new Response('Hello ' . $name);
    }

    private function getConfig()
    {
        return include __DIR__ . '/../../app/config.php';
    }
}