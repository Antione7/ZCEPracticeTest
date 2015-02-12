<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Credits\Service;

use ZCEPracticeTest\Core\Entity\User;
use ZCEPracticeTest\Credits\Entity\Credits;

/**
 * Credits initializer
 * Initialize credits data for an user
 *
 * @category Service
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class CreditsInitializer
{
    /**
     * @var integer
     */
    private $freeCreditsInit;
    
    /**
     * @param integer $freeCreditsInit
     */
    public function __construct($freeCreditsInit)
    {
        $this->freeCreditsInit = $freeCreditsInit;
    }
    
    /**
     * @param User $user
     * 
     * @return Credits
     */
    public function initCreditsForUser(User $user)
    {
        $credits = new Credits();
        
        $credits
            ->setUser($user)
            ->setRemaining($this->freeCreditsInit)
            ->setUsed(0)
            ->setPaid(0.0)
        ;
        
        return $credits;
    }
}
