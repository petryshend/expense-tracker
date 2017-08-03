<?php

namespace Expense;

use DataBase\Connection;

class Repository
{
    /** @var Connection */
    private $connection;

    function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Record[]
     */
    public function getAll(): array
    {
        $stmt = $this->connection->pdo()->query('SELECT * FROM expenses');
        $pdo = null;
        return array_map(function($row) {
            return new Record($row['id'], $row['title'], $row['amount'], new \DateTimeImmutable($row['created_at']));
        }, $stmt->fetchAll());
    }
}