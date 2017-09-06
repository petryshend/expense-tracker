<?php

namespace Expense;

use Doctrine\ORM\EntityManager;
use Simplex\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends BaseController
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct()
    {
        $this->entityManager = $this->get('entity.manager');
    }

    public function indexAction(): Response
    {
        /** @var RecordRepository $recordsRepo */
        $recordsRepo = $this->entityManager->getRepository(Record::class);
        $records = $recordsRepo->findByDate(new \DateTimeImmutable());
        return $this->render('index', [
            'records' => $records,
            'total_spent' => $this->getTotalSpent($records),
            'today_view' => true,
            'expense_types' => ExpenseType::values(),
        ]);
    }

    public function allRecordsAction(): Response
    {
        $repository = $this->entityManager->getRepository(Record::class);
        $records = $repository->findAll();
        return $this->render('index', [
            'records' => $records,
            'total_spent' => $this->getTotalSpent($records),
            'expense_types' => ExpenseType::values(),
        ]);
    }

    public function newExpenseAction(Request $request): Response
    {
        if (!$request->isMethod('post')) {
            return new RedirectResponse('/');
        }

        $type = $request->get('new-expense-type');
        $amount = $request->get('new-expense-amount');
        $comment = $request->get('new-expense-comment');

        if (!$type || !$amount) {
            return new RedirectResponse('/');
        }

        $record = new Record(new ExpenseType($type), $amount, $comment);
        $this->entityManager->persist($record);
        $this->entityManager->flush();

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