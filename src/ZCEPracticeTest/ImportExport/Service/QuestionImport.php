<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  ImportExport
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\ImportExport\Service;

use ZCEPracticeTest\Core\Entity\Topic;
use ZCEPracticeTest\Core\Entity\QuestionQCMChoice;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Repository\TopicRepository;

/**
 * Import questions
 *
 * @category Service
 * @package  ImportExport
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionImport
{
    /**
     * @var TopicRepository
     */
    private $topicRepository;
    
    /**
     * @var Topic[]
     */
    private $topics;
    
    /**
     * @param TopicRepository $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }
    
    /**
     * Get topic by number order.
     * 
     * @param integer $number from 1 to 10
     * 
     * @return Topic
     */
    private function getTopic($number)
    {
        if (!is_array($this->topics)) {
            $this->topics = $this->topicRepository->findBy(array(), array(
                'id' => 'ASC',
            ));
        }
        
        return $this->topics[$number - 1];
    }
    
    /**
     * Create array of question from csv file handler
     * 
     * @param resource $file
     * 
     * @return array
     */
    public function processFile($file)
    {
        $questions = array();
        
        while (false !== ($line = fgetcsv($file))) {
            $questions []= $this->processCsvLine($line);
        }
        
        return $questions;
    }
    
    /**
     * Process a single line
     * 
     * @param string $data
     * 
     * @return Question
     */
    public function processCsvLine(array $data)
    {
        $question = new Question();
        
        $question
            ->setEntitled($data[0])
            ->setTopic($this->getTopic(intval($data[1])))
            ->setCode($data[2])
        ;
        
        $isFreeQuestion = 0 === strlen($data[4]);
        
        if ($isFreeQuestion) {
            $this->processFreeQuestion($question, $data);
        } else {
            $this->processQCMQuestion($question, $data);
        }
        
        return $question;
    }
    
    /**
     * Hydrate question with QCM question data
     * 
     * @param Question $question
     * 
     * @param array $data
     */
    private function processQCMQuestion(Question $question, array $data)
    {
        $nbAnswers = 0;
        $i = 4;

        while (($i < count($data)) && (strlen($data[$i]) > 0)) {
            $choice = new QuestionQCMChoice();

            $choice
                ->setQuestion($question)
                ->setEntitled($data[$i - 1])
                ->setIsValid(filter_var($data[$i], FILTER_VALIDATE_BOOLEAN))
            ;

            $question->addQuestionQCMChoice($choice);

            $i += 2;
            $nbAnswers++;
        }

        $question
            ->setType(Question::TYPE_QCM)
            ->setNbAnswers($nbAnswers)
        ;
    }
    
    /**
     * Hydrate question with free question data
     * 
     * @param Question $question
     * 
     * @param array $data
     */
    private function processFreeQuestion(Question $question, array $data)
    {
        $question
            ->setType(Question::TYPE_FREE)
            ->setFreeAnswer($data[3])
        ;
    }
}
