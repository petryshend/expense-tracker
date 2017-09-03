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
        ]);
    }

    public function allRecordsAction(): Response
    {
        $repository = $this->entityManager->getRepository(Record::class);
        $records = $repository->findAll();
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