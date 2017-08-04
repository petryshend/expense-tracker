<?php

namespace Expense;

use DataBase\Connection;
use PDO;

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
        $stmt = $this->connection->pdo()->query('SELECT * FROM expenses ORDER BY id DESC');
        return array_map(function($row) {
            return (new Record($row['title'], $row['amount']))
                ->setId($row['id'])
                ->setCreatedAt(new \DateTimeImmutable($row['created_at']));
        }, $stmt->fetchAll());
    }

    public function insert(Record $record)
    {
        $stmt = $this->connection->pdo()->prepare('INSERT INTO expenses (title, amount) VALUES (:title, :amount)');
        $stmt->bindParam(':title', $record->getTitle(), PDO::PARAM_STR);
        $stmt->bindParam(':amount', $record->getAmount(), PDO::PARAM_INT);
        $stmt->execute();
    }
}