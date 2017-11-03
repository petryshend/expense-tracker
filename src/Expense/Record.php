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
    private $type;
    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    private $comment;
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

    function __construct(ExpenseType $type, float $amount, string $comment = '')
    {
        $this->type = $type->getValue();
        $this->amount = $amount;
        $this->comment = $comment;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'comment' => $this->comment,
            'amount' => $this->amount,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s')
        ];
    }
}