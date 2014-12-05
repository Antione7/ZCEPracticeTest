<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use SimpleUser\User as BaseUser;

/**
 * User entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max="63"
     * )
     */
    private $firstName;

    /**
     * @var string
     * 
     * @Assert\Length(
     *      max="63"
     * )
     */
    private $lastName;
    
    /**
     * Constructor
     * 
     * @param string $email
     */
    public function __construct($email)
    {
        parent::__construct($email);
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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}
