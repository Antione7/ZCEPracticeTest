<?php

/**
 * PHP version 5.5
 *
 * @category Listener
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */

namespace ZCEPracticeTest\Credits\Listener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Core\Event\SessionEvent;
use ZCEPracticeTest\Core\Repository\QuizRepository;
use ZCEPracticeTest\Credits\Exception\CreditsSystemException;
use ZCEPracticeTest\Credits\Entity\Credits;
use ZCEPracticeTest\Credits\Service\CreditsManager;

/**
 * @category Listener
 * @package  Credits
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class FirstQuizCreationListener implements EventSubscriberInterface
{
    /**
     * @var CreditsManager
     */
    private $creditsManager;
    
    /**
     * @var QuizRepository
     */
    private $quizRepository;
    
    /**
     * @var string
     */
    private $firstQuizName;
    
    /**
     * @param CreditsManager $creditsManager
     * @param QuizRepository $quizRepository
     * @param string $firstQuizName
     */
    public function __construct(CreditsManager $creditsManager, QuizRepository $quizRepository, $firstQuizName)
    {
        $this->creditsManager = $creditsManager;
        $this->quizRepository = $quizRepository;
        $this->firstQuizName = $firstQuizName;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            SessionEvent::BEFORE_CREATE_SESSION => array(
                'onBeforeCreateSession',
            ),
        );
    }
    
    /**
     * @param SessionEvent $event
     */
    public function onBeforeCreateSession(SessionEvent $event)
    {
        $credits = $this->creditsManager->getCredits();
        
        if (self::isFreeQuiz($credits)) {
            $freeQuiz = $this->quizRepository->findOneBy(array(
                'name' => $this->firstQuizName,
            ));
            
            if (null === $freeQuiz) {
                throw new CreditsSystemException(
                    'Free quiz "'.$this->firstQuizName.'" not found in database.'
                );
            }
            
            $event->getSession()->setQuiz($freeQuiz);
        }
    }
    
    /**
     * Return whether we should return the free quiz from credits state.
     * 
     * @param Credits $credits
     * 
     * @return boolean
     */
    private static function isFreeQuiz(Credits $credits)
    {
        // Check if user already paid credits
        if ($credits->getPaid() > 0) {
            return false;
        }
        
        // Return whether user has never used credits
        return 0 === $credits->getUsed();
    }
}
