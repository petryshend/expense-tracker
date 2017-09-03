<?php

namespace Expense;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="Expense\RecordRepository")
 * @Table(name="expenses")
 */
class Record
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @Column(type="string")
     */
    private $title;
    /**
     * @var float
     * @Column(type="float")
     */
    private $amount;                               
    /**
     * @var \DateTimeImmutable
     * @Column(type="datetime", name="created_at")
     */
    private $createdAt;

    function __construct(string $title, float $amount)
    {
        $this->title = $title;
        $this->amount = $amount;
        $this->createdAt = new \DateTimeImmutable();
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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}