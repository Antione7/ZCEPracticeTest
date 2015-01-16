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

use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Core\Entity\User;
use ZCEPracticeTest\Credits\Entity\Credits;
use ZCEPracticeTest\Credits\Repository\CreditsRepository;

/**
 * Credits manager service
 * Create/update credits data for an user
 *
 * @category Service
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class CreditsManager
{
    /**
     * @var CreditsRepository
     */
    private $creditsRepository;
    
    /**
     * @var array
     */
    private $creditsData;
    
    /**
     * @param CreditsRepository $creditsRepository
     */
    public function __construct(CreditsRepository $creditsRepository)
    {
        $this->creditsRepository = $creditsRepository;
        
        $this->creditsData = array();
    }
    
    /**
     * Return credits data for an user
     * 
     * @param User $user
     * 
     * @return Credits
     */
    private function getCredits(User $user)
    {
        if (!isset(array_key_exists($user->getId(), $this->creditsData))) {
            $credits = $this->creditsRepository->loadCreditsData($user->getId());
            $this->creditsData[$user->getId()] = $credits;
        }
        
        return $this->creditsData[$user->getId()];
    }
    
    /**
     * Check whether $user has credits
     * 
     * @param User $user
     * 
     * @return boolean
     */
    public function hasCredits(User $user)
    {
        $credits = $this->getCredits($user);
        
        return $credits->getRemaining() > 0;
    }
    
    /**
     * User use a credit
     * 
     * @param User $user
     * 
     * @return Credits
     */
    public function useCredits(User $user)
    {
        $credits = $this->getCredits($user);
        
        $credits->setRemaining($credits->getRemaining() - 1);
        
        return $credits;
    }
}
