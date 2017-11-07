<?php

namespace Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
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
     * @var \DateTime
     * @Column(type="datetime", name="created_at")
     */
    private $createdAt;

    /**
     * @var User
     * @ManyToOne(targetEntity="User", inversedBy="records")
     */
    private $user;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Record
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Record
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return Record
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Record
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'comment' => $this->comment,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'amount' => $this->amount,
            'user_id' => $this->user->getId(),
        ];
    }
}
