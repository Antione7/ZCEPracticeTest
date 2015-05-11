<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Credits\Entity;

use ZCEPracticeTest\Core\Entity\User;

/**
 * Answer entity
 *
 * @category Entity
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Credits implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * Total credits currently available
     * 
     * @var integer
     */
    private $remaining;
    
    /**
     * Total amount paid from account creation
     * 
     * @var double
     */
    private $paid;
    
    /**
     * Number of credits used from account creation
     * 
     * @var integer
     */
    private $used;
    
    /**
     * @var User
     */
    private $user;
    
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
     * Set remaining
     *
     * @param integer $remaining
     * @return Credits
     */
    public function setRemaining($remaining)
    {
        $this->remaining = $remaining;

        return $this;
    }

    /**
     * Get remaining
     *
     * @return integer 
     */
    public function getRemaining()
    {
        return $this->remaining;
    }

    /**
     * Set paid
     *
     * @param double $paid
     * @return Credits
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return double
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set used
     *
     * @param integer $used
     * @return Credits
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return integer 
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Credits
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
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
        );
    }
}
