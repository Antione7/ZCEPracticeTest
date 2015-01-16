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

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use ZCEPracticeTest\Credits\Exception\CreditsSystemException;
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
     * @var TokenInterface
     */
    private $token;
    
    /**
     * @var Credits
     */
    private $credits;
    
    /**
     * @param CreditsRepository $creditsRepository
     * @param TokenInterface $token
     */
    public function __construct(CreditsRepository $creditsRepository, TokenInterface $token)
    {
        $this->creditsRepository = $creditsRepository;
        $this->token = $token;
        
        $this->credits = null;
    }
    
    /**
     * @return Credits
     */
    public function getCredits()
    {
        if (null === $this->credits) {
            $userId = $this->getUser()->getId();
            $this->credits = $this->creditsRepository->loadCreditsData($userId);
            
            if (null === $this->credits) {
                $this->credits = new Credits();
                $this->credits->setUser($this->getUser());
            }
        }
        
        return $this->credits;
    }
    
    /**
     * Check whether $user has credits
     * 
     * @return boolean
     */
    public function hasCredits()
    {
        $credits = $this->getCredits();
        
        return $credits->getRemaining() > 0;
    }
    
    /**
     * User use a credit
     * 
     * @return Credits
     */
    public function useCredits()
    {
        $credits = $this->getCredits();
        
        if (!$this->hasCredits()) {
            throw new CreditsSystemException('Cannot use credits, 0 left');
        }
        
        $credits->setRemaining($credits->getRemaining() - 1);
        $credits->setUsed($credits->getUsed() + 1);
        
        return $credits;
    }
    
    /**
     * @return User
     * 
     * @throws CreditsSystemException if no user
     */
    private function getUser()
    {
        $user = $this->token->getUser();
        
        if (null === $user) {
            throw new CreditsSystemException('No user');
        }
        
        return $user;
    }
}
