<?php

namespace Api;

use Expense\Record;
use Expense\RecordRepository;
use Simplex\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends BaseController
{
    public function expensesAction(): Response
    {
        /** @var RecordRepository $recordsRepo */
        $recordsRepo = $this->get('entity.manager')->getRepository(Record::class);
        $records = $recordsRepo->findAll();
        return new JsonResponse(array_map(function(Record $record) {
            return $record->serialize();
        }, $records));
    }
}