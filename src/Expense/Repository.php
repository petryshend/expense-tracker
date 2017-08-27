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
        return $this->getResult($stmt->fetchAll());
    }

    public function getByDate(\DateTimeInterface $dateTime): array
    {
        $stmt = $this->connection->pdo()->prepare(
            <<<'SQL'
            SELECT * FROM expenses
            WHERE created_at >= :created_at::DATE
              AND created_at < (:created_at::DATE + '1 day'::INTERVAL)
            ORDER BY id DESC
SQL
        );
        $date = $dateTime->format('Y-m-d H:i:s');
        $stmt->bindParam(':created_at', $date, PDO::PARAM_STR);
        $stmt->execute();
        return $this->getResult($stmt->fetchAll());
    }

    public function insert(Record $record)
    {
        $stmt = $this->connection->pdo()->prepare('INSERT INTO expenses (title, amount) VALUES (:title, :amount)');
        $title = $record->getTitle();
        $amount = $record->getAmount();
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * @param mixed $rows
     * @return Record[]
     */
    private function getResult(array $rows): array
    {
        return array_map(function($row) {
            return (new Record($row['title'], $row['amount']))
                ->setId($row['id'])
                ->setCreatedAt(new \DateTimeImmutable($row['created_at']));
        }, $rows);
    }
}