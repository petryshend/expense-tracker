<?php

namespace DataBase;

use PDO;

class Connection
{
    /** @var PDO */
    private $pdo;

    function __construct(string $driver, string $host, string $port, string $dbname, string $username, string $password)
    {
        $this->pdo = new \PDO(
            sprintf('%s:host=%s;port=%s;dbname=%s', $driver, $host, $port, $dbname),
            $username,
            $password
        );
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }
}