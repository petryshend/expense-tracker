<?php

namespace Expense;

use Simplex\BaseController;
use Simplex\UserEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
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
        $records = $this->expenses->getByDate(new \DateTimeImmutable('now'));
        return $this->render('index', [
            'records' => $records,
            'total_spent' => $this->getTotalSpent($records),
            'today_view' => true,
        ]);
    }

    public function allRecordsAction(): Response
    {
        $records = $this->expenses->getAll();
        return $this->render('index', [
            'records' => $records,
            'total_spent' => $this->getTotalSpent($records),
        ]);
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

    /**
     * @param Record[] $records
     * @return float
     */
    private function getTotalSpent(array $records): float
    {
        return array_sum(array_map(function(Record $record) {
            return $record->getAmount();
        }, $records));
    }
}