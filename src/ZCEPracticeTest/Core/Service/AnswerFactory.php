<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Service;

use ZCEPracticeTest\Core\Entity\Session;
use ZCEPracticeTest\Core\Entity\Answer;
use ZCEPracticeTest\Core\Repository\QuestionRepository;
use ZCEPracticeTest\Core\Entity\AnswerQCMChoice;

/**
 * Answer factory service.
 *
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class AnswerFactory
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    
    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        QuestionRepository $questionRepository
    ) {
        $this->questionRepository = $questionRepository;
    }
    
    /**
     * Create blank answer
     * 
     * @param Session $session
     * @param integer $questionId
     * 
     * @return Answer
     */
    public function createAnswer(Session $session, $questionId)
    {
        $answer = new Answer();
        
        $question = $this->questionRepository->findFull($questionId);
        
        $answer
            ->setDateCreated(new \DateTime())
            ->setSession($session)
            ->setQuestion($question)
            ->setTagged(false)
        ;
        
        return $answer;
    }
    
    /**
     * Create qcm answer from array of choices id
     * 
     * @param Session $session
     * @param integer $questionId
     * @param array $selected
     * 
     * @return Answer
     */
    public function createQCMAnswer(Session $session, $questionId, array $selected)
    {
        $answer = $this->createAnswer($session, $questionId);
        
        $question = $answer->getQuestion();
        
        foreach ($question->getQuestionQCMChoices() as $questionQCMChoice) {
            if (in_array($questionQCMChoice->getId(), $selected)) {
                $answerQCMChoice = new AnswerQCMChoice();

                $answerQCMChoice
                    ->setAnswer($answer)
                    ->setQuestionQCMChoice($questionQCMChoice)
                ;
                
                $answer->addAnswerQCMChoice($answerQCMChoice);
            }
        }
        
        return $answer;
    }
    
    /**
     * Create free answer from string
     * 
     * @param Session $session
     * @param integer $questionId
     * @param string $freeAnswer
     * 
     * @return Answer
     */
    public function createFreeAnswer(Session $session, $questionId, $freeAnswer)
    {
        $answer = $this->createAnswer($session, $questionId);
        
        $answer->setFreeAnswer($freeAnswer);
        
        return $answer;
    }
}
