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

    function __construct(string $title, float $amount)
    {
        $this->title = $title;
        $this->amount = $amount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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

    public function setCreatedAt(\DateTimeImmutable $createdAd): self
    {
        $this->createdAt = $createdAd;
        return $this;
    }
}