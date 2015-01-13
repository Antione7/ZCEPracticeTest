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
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Entity\AnswerQCMChoice;
use ZCEPracticeTest\Core\Service\AnswerFactory;
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
     * @var AnswerFactory
     */
    private $answerFactory;
    
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
            AnswerFactory $answerFactory,
            TokenInterface $token,
            ObjectManager $om
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->zcpeQuizFactory = $zcpeQuizFactory;
        $this->answerFactory = $answerFactory;
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
     * @param Request $request
     * @param integer $sessionId
     * 
     * @return JsonResponse
     */
    public function finishAction(Request $request, $sessionId)
    {
        $scoreData = json_decode($request->getContent());
        $userSession = $this->token->getUser();
        
        if (null === $scoreData) {
            throw new UserException('no.score.data');
        }
        
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
            ->setNbTopicsValidated($scoreData->nbTopicsValidated)
            ->setSuccess($scoreData->success)
        ;
        
        $this->om->flush();
        
        return new JsonResponse(array(
            'ok' => true,
        ));
    }
    
    /**
     * Persist multiple user answers
     * 
     * @param Request $request
     * @param integer $sessionId
     * 
     * @return JsonResponse
     */
    public function postAnswersAction(Request $request, $sessionId)
    {
        $answersData = json_decode($request->getContent());
        $userSession = $this->token->getUser();
        
        if (!($userSession instanceof User)) {
            throw new UserException('user.not.logged');
        }
        
        $user = $this->om->merge($userSession);
        $session = $this->sessionRepository->getFullSession($sessionId, $user->getId());
        
        if (null === $session) {
            throw new UserException('user.session.not.found');
        }
        
        foreach ($answersData as $answerData) {
            $answer = null;
            
            if ($answerData->type == Question::TYPE_QCM) {
                $answer = $this->answerFactory->createQCMAnswer($session, $answerData->questionId, $answerData->selected);
            }
            
            if ($answerData->type == Question::TYPE_FREE) {
                $answer = $this->answerFactory->createFreeAnswer($session, $answerData->questionId, $answerData->freeAnswer);
            }
            
            $this->om->persist($answer);
        }
        
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
