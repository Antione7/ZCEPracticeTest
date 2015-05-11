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

use Doctrine\ORM\EntityRepository;
use ZCEPracticeTest\Core\Entity\Quiz;

/**
 * ZCPE Quiz factory service.
 * 
 * Create random ZCPE quiz
 *
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class ZCPEQuizFactory
{
    /**
     * @var QuizFactory
     */
    private $quizFactory;
    
    /**
     * @var EntityRepository
     */
    private $topicRepository;
    
    /**
     * @var EntityRepository
     */
    private $questionRepository;
    
    /**
     * @param QuizFactory $quizFactory
     * @param EntityRepository $topicRepository
     * @param EntityRepository $questionRepository
     */
    public function __construct(
        QuizFactory $quizFactory,
        EntityRepository $topicRepository,
        EntityRepository $questionRepository
    ) {
        $this->quizFactory = $quizFactory;
        $this->topicRepository = $topicRepository;
        $this->questionRepository = $questionRepository;
    }
    
    /**
     * Create a standard ZCPE Quiz with 70 questions,
     * 40% of about primary topics,
     * 60% of secondary topics.
     * 
     * @return Quiz
     */
    public function createStandardZCPEQuiz()
    {
        $topics = $this->topicRepository->findAll();
        $percentages = array();
        
        foreach ($topics as $topic) {
            if ($topic->getPrimary()) {
                $percentages []= array($topic, 0.4 / 3);
            } else {
                $percentages []= array($topic, 0.6 / 7);
            }
        }
        
        $questions = $this->questionRepository->findAll();
        
        return $this->quizFactory->createCategorizedRandomQuiz($questions, 70, $percentages);
    }
}
