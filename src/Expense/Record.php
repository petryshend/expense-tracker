<?php

namespace Expense;

class Record
{
    /** @var int */
    private $id;
    /** @var string */
    private $title;                                
    /** @var float */                              
    private $amount;                               
    /** @var \DateTimeImmutable */
    private $createdAt;

    function __construct(int $id, string $title, float $amount, \DateTimeInterface $createdAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->amount = $amount;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}