<?php

/**
 * PHP version 5.5
 *
 * @category Controller
 * @package  Rest
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Rest\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use ZCEPracticeTest\Core\Exception\UserException;
use ZCEPracticeTest\Core\Entity\Session;
use ZCEPracticeTest\Core\Entity\User;
use ZCEPracticeTest\Core\Service\ZCPEQuizFactory;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  Rest
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class SessionController
{
    /**
     * @var ZCPEQuizFactory
     */
    private $zcpeQuizFactory;
    
    /**
     * @var EntityRepository
     */
    private $sessionRepository;
    
    /**
     * @var TokenInterface
     */
    private $token;
    
    /**
     * @var ObjectManager
     */
    private $om;
    
    /**
     * @param EntityRepository $sessionRepository
     * @param ZCPEQuizFactory $zcpeQuizFactory
     * @param TokenInterface $token
     * @param ObjectManager $om
     */
    public function __construct(
            EntityRepository $sessionRepository,
            ZCPEQuizFactory $zcpeQuizFactory,
            TokenInterface $token,
            ObjectManager $om
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->zcpeQuizFactory = $zcpeQuizFactory;
        $this->token = $token;
        $this->om = $om;
    }
    
    /**
     * @return JsonResponse
     */
    public function createAction()
    {
        $userSession = $this->token->getUser();
        
        if (!($userSession instanceof User)) {
            throw new UserException('user.not.logged');
        }
        
        $user = $this->om->merge($userSession);
        $quiz = $this->zcpeQuizFactory->createStandardZCPEQuiz();
        $session = new Session();
        
        $session
            ->setUser($user)
            ->setQuiz($quiz)
        ;
        
        $this->om->persist($session);
        $this->om->flush();
        
        return new JsonResponse($session);
    }
    
    /**
     * Set pass/fail state and save score
     * 
     * @param integer $sessionId
     * @param array $data
     * 
     * @return JsonResponse
     */
    public function finishAction(Request $request, $sessionId)
    {
        $scoreData = $request->get('scoreData');
        $userSession = $this->token->getUser();
        
        if (!($userSession instanceof User)) {
            throw new UserException('user.not.logged');
        }
        
        $user = $this->om->merge($userSession);
        $session = $this->sessionRepository->getFullSession($sessionId, $user->getId());
        
        if (null === $session) {
            throw new UserException('user.session.not.found');
        }
        
        $session
            ->setDateFinished(new \DateTime())
            ->setNbTopicsValidated($scoreData['nbTopicsValidated'])
            ->setSuccess($scoreData['success'] === 'true')
        ;
        
        $this->om->flush();
        
        return new JsonResponse(array(
            'ok' => true,
        ));
    }
    
    /**
     * @return JsonResponse
     */
    public function getAllAction()
    {
        $userSession = $this->token->getUser();
        
        if (!($userSession instanceof User)) {
            throw new UserException('user.not.logged');
        }
        
        $user = $this->om->merge($userSession);
        
        $sessions = $this->sessionRepository->findBy(array(
            'user' => $user,
        ));
        
        return new JsonResponse(array(
            'sessions' => $sessions,
        ));
    }
}
