<?php

/**
 * PHP version 5.5
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Front\Controller;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\ORM\EntityRepository;
use Twig_Environment as Twig;
use ZCEPracticeTest\Core\Exception\UserException;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class SessionController
{
    /**
     * @var Twig
     */
    private $twig;
    
    /**
     * @var TokenInterface
     */
    private $tokenInterface;
    
    /**
     * @var EntityRepository
     */
    private $sessionRepository;
    
    public function __construct(Twig $twig, TokenInterface $tokenInterface, EntityRepository $sessionRepository)
    {
        $this->twig = $twig;
        $this->tokenInterface = $tokenInterface;
        $this->sessionRepository = $sessionRepository;
    }
    
    public function indexAction()
    {
        $user = $this->tokenInterface->getUser();
        $sessions = $this->sessionRepository->findBy(array(
            'user' => $user,
        ));
        
        return $this->twig->render('@session/index.html.twig', array(
            'sessions' => $sessions,
        ));
    }
    
    public function newAction()
    {
        return $this->twig->render('@session/new.html.twig');
    }
    
    public function quizAction($sessionId)
    {
        $user = $this->tokenInterface->getUser();
        $session = $this->sessionRepository->getFullSession($sessionId, $user->getId());
        
        if (null === $session) {
            throw new UserException('session.and.user.not.found', 404);
        }
        
        return $this->twig->render('@session/quiz.html.twig', array(
            'session' => $session,
        ));
    }
}
