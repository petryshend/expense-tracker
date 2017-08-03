<?php

namespace Expense;

class Repository
{
    /**
     * @return Record[]
     */
    public function getAll(): array
    {
        $pdo = $this->connect();
        $stmt = $pdo->query('SELECT * FROM expenses');
        $pdo = null;
        return array_map(function($row) {
            return new Record($row['id'], $row['title'], $row['amount'], new \DateTimeImmutable($row['created_at']));
        }, $stmt->fetchAll());
    }

    private function connect()
    {
        return new \PDO('pgsql:host=localhost;port=5432;dbname=expense_tracker', 'postgres', 'postgres');
    }
}