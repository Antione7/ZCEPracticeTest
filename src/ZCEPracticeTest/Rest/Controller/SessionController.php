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

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use ZCEPracticeTest\Core\Exception\UserException;
use ZCEPracticeTest\Core\Entity\Session;
use ZCEPracticeTest\Core\Entity\TopicScore;
use ZCEPracticeTest\Core\Entity\User;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Service\AnswerFactory;
use ZCEPracticeTest\Core\Service\ZCPEQuizFactory;
use ZCEPracticeTest\Core\Event\SessionEvent;
use ZCEPracticeTest\Core\Repository\SessionRepository;

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
     * @var SessionRepository
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
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * @var EventDispatcher
     */
    private $dispatcher;
    
    /**
     * @param SessionRepository $sessionRepository
     * @param ZCPEQuizFactory $zcpeQuizFactory
     * @param TokenInterface $token
     * @param EntityManagerInterface $em
     * @param EventDispatcher $dispatcher
     */
    public function __construct(
        SessionRepository $sessionRepository,
        ZCPEQuizFactory $zcpeQuizFactory,
        AnswerFactory $answerFactory,
        TokenInterface $token,
        EntityManagerInterface $em,
        EventDispatcher $dispatcher
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->zcpeQuizFactory = $zcpeQuizFactory;
        $this->answerFactory = $answerFactory;
        $this->token = $token;
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }
    
    /**
     * @return JsonResponse
     */
    public function createAction()
    {
        $user = $this->loadUser();
        $quiz = $this->zcpeQuizFactory->createStandardZCPEQuiz();
        $session = new Session();
        
        $session
            ->setUser($user)
            ->setQuiz($quiz)
        ;
        
        $this->em->persist($session);
        $this->em->flush();
        
        return new JsonResponse(array(
            'ok' => true,
            'session' => $session,
        ));
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
        
        if (null === $scoreData) {
            throw new UserException('no.score.data');
        }
        
        $user = $this->loadUser();
        $session = $this->sessionRepository->getFullSession($sessionId, $user->getId());
        
        if (null === $session) {
            throw new UserException('user.session.not.found');
        }
        
        $session
            ->setDateFinished(new \DateTime())
            ->setNbTopicsValidated($scoreData->nbTopicsValidated)
            ->setSuccess($scoreData->success)
        ;
        
        foreach ($scoreData->topics as $topicScoreData) {
            $topicScore = new TopicScore();
            
            $topicScore
                ->setTopic($this->em->getReference('ZCE:Topic', $topicScoreData->topic->id))
                ->setSession($session)
                ->setSuccess($topicScoreData->validated)
            ;
            
            $session->addTopicScore($topicScore);
        }
        
        $this->em->flush();
        
        $this->dispatcher->dispatch(SessionEvent::SESSION_ENDED, new SessionEvent($session));
        
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
        $user = $this->loadUser();
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
            
            $this->em->persist($answer);
        }
        
        $this->em->flush();
        
        return new JsonResponse(array(
            'ok' => true,
        ));
    }
    
    /**
     * @return JsonResponse
     */
    public function getAllAction()
    {
        $user = $this->loadUser();
        
        $sessions = $this->sessionRepository->findBy(array(
            'user' => $user,
        ));
        
        return new JsonResponse(array(
            'ok' => true,
            'sessions' => $sessions,
        ));
    }
    
    /**
     * Return a full session
     * 
     * @param integer $sessionId
     * 
     * @return JsonResponse
     */
    public function getAction($sessionId)
    {
        $user = $this->loadUser();
        $session = $this->sessionRepository->getFullSession($sessionId, $user->getId());
        
        return new JsonResponse(array(
            'ok' => true,
            'session' => $session,
        ));
    }
    
    /**
     * Load logged user
     * 
     * @return User
     * 
     * @throws UserException if no user logged
     */
    private function loadUser()
    {
        $userSession = $this->token->getUser();
        
        if (!($userSession instanceof User)) {
            throw new UserException('user.not.logged');
        }
        
        return $this->em->merge($userSession);
    }
}
