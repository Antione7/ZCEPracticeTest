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
use Doctrine\Common\Persistence\ObjectManager;
use Twig_Environment as Twig;

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
    
    public function __construct(
        Twig $twig,
        TokenInterface $tokenInterface,
        EntityRepository $sessionRepository
    ) {
        $this->twig = $twig;
        $this->tokenInterface = $tokenInterface;
        $this->sessionRepository = $sessionRepository;
    }
    
    public function indexAction()
    {
        $user = $this->tokenInterface->getUser();
        $sessions = $this->sessionRepository->findBy(array(
            'user' => $user,
        ), array('dateFinished' => 'DESC'));

        return $this->twig->render('@session/index.html.twig', array(
            'sessions' => $sessions,
        ));
    }
}
