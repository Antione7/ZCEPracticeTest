<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  Core
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
class User extends BaseUser implements \JsonSerializable
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
     * @var Session[]
     */
    private $sessions;

    /**
     * Constructor
     * 
     * @param string $email
     */
    public function __construct($email)
    {
        parent::__construct($email);
        
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Add sessions
     *
     * @param Session $sessions
     * @return User
     */
    public function addSession(Session $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param Session $sessions
     */
    public function removeSession(Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return Session[] 
     */
    public function getSessions()
    {
        return $this->sessions;
    }
    
    /**
     * @param integer $size
     * 
     * @return string
     */
    public function getGravatarImage($size = 64)
    {
        return '//www.gravatar.com/avatar/' . md5(strtolower(trim($this->getEmail()))) . '?s=' . $size . '&d=identicon';
    }
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'displayName' => $this->getDisplayName(),
            'gravatarImage' => $this->getGravatarImage(),
            'timeCreate' => new \DateTime('@'.$this->getTimeCreated()),
        );
    }
}
