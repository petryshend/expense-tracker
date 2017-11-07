<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="users")
 */
class User
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
    private $email;

    /**
     * @var string
     * @Column(type="string")
     */
    private $password;

    /**
     * @OneToMany(targetEntity="Record", mappedBy="user")
     */
    private $records;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->records = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add record
     *
     * @param Record $record
     *
     * @return User
     */
    public function addRecord(Record $record)
    {
        $this->records[] = $record;

        return $this;
    }

    /**
     * Remove record
     *
     * @param Record $record
     */
    public function removeRecord(Record $record)
    {
        $this->records->removeElement($record);
    }

    /**
     * Get records
     *
     * @return Collection
     */
    public function getRecords()
    {
        return $this->records;
    }
}
