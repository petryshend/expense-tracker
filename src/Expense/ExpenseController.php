<?php

namespace Expense;

use Simplex\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends BaseController
{
    /** @var Repository */
    private $expenses;

    public function __construct()
    {
        $this->expenses = $this->get('expense.record');
    }

    public function indexAction(): Response
    {
        if (!isset($_SESSION['username'])) {
            return new RedirectResponse('/login');
        }
        return $this->render('index', ['records' => $this->expenses->getAll()]);
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
}