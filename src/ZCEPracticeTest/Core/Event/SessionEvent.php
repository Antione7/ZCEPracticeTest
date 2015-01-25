<?php

/**
 * PHP version 5.5
 *
 * @category Event
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Event;

use ZCEPracticeTest\Core\Entity\Session;

/**
 * Event abstract.
 *
 * @category Event
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class SessionEvent extends EventAbstract
{
    /**
     * @var Session
     */
    private $session;
    
    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    
    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }
}
