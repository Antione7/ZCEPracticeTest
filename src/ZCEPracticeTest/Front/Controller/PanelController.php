<?php

/**
 * PHP version 5.5
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @author   Cyrille Grandval <cgrandval@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Front\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\ORM\EntityRepository;
use Twig_Environment as Twig;
use ZCEPracticeTest\Core\Entity\User;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class PanelController
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
    
    /**
     * @var string
     */
    private $baseUrl;
    
    /**
     * @param Twig $twig
     * @param TokenInterface $tokenInterface
     * @param EntityRepository $sessionRepository
     * @param string $baseUrl
     */
    public function __construct(
        Twig $twig,
        TokenInterface $tokenInterface,
        EntityRepository $sessionRepository,
        $baseUrl
    ) {
        $this->twig = $twig;
        $this->tokenInterface = $tokenInterface;
        $this->sessionRepository = $sessionRepository;
        $this->baseUrl = $baseUrl;
    }
    
    public function indexAction()
    {
        $user = $this->tokenInterface->getUser();
        
        if (!($user instanceof User)) {
            return new RedirectResponse($this->baseUrl);
        }
        
        $sessions = $this->sessionRepository->findBy(array(
            'user' => $user,
        ), array('dateFinished' => 'DESC'));
        
       
        return $this->twig->render('@panel/index.html.twig', array(
            'sessions' => $sessions,
        ));
    }
}
