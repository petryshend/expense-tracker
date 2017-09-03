<?php

namespace Expense;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class RecordRepository extends EntityRepository
{
    public function findByDate(\DateTimeInterface $dateTime): array
    {
        $sql =
            <<<'SQL'
            SELECT * FROM expenses r
            WHERE r.created_at >= :created_at::DATE
              AND r.created_at < (:created_at::DATE + '1 day'::INTERVAL)
            ORDER BY id DESC;
SQL
        ;

        $query = $this->getEntityManager()->createNativeQuery($sql, $this->getRsm());
        $query->setParameter('created_at', $dateTime->format('Y-m-d H:i:s'));

        return $query->getResult();

    }

    private function getRsm(): ResultSetMappingBuilder
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(Record::class, 'r');
        return $rsm;
    }
}