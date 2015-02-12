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
use ZCEPracticeTest\ImportExport\Exception\ParseException;

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
     * @param mixed $key number between 1 and 10 or key
     * 
     * @return Topic
     */
    private function getTopic($key)
    {
        if (!is_array($this->topics)) {
            $this->topics = $this->topicRepository->findBy(array(), array(
                'id' => 'ASC',
            ));
        }
        
        return $this->topics[$this->getTopicNumber($key)];
    }
    
    /**
     * Create array of question from csv file handler
     * 
     * @param resource $file
     * @param boolean $skipFirstLine
     * 
     * @return Question[]
     * 
     * @throws ParseException
     */
    public function processFile($file, $skipFirstLine = false)
    {
        $questions = array();
        
        while (false !== ($line = fgetcsv($file))) {
            if ($skipFirstLine) {
                $skipFirstLine = false;
                continue;
            }
            
            try {
                $questions []= $this->processCsvLine($line);
            } catch (ParseException $e) {
                throw new ParseException($e->getMessage(), count($questions) + 1);
            }
        }
        
        return $questions;
    }
    
    /**
     * Process a single line
     * 
     * @param string $data
     * 
     * @return Question
     * 
     * @throws ParseException
     */
    public function processCsvLine(array $data)
    {
        $question = new Question();
        
        $question
            ->setEntitled($data[0])
            ->setTopic($this->getTopic($data[1]))
        ;
        
        if ((null !== $data[2]) && (strlen($data[2]) > 0)) {
            $question->setCode($data[2]);
        }
        
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
     * @param array $data
     * 
     * @throws ParseException
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
                ->setValid(filter_var($data[$i], FILTER_VALIDATE_BOOLEAN))
            ;

            $question->addQuestionQCMChoice($choice);

            if ($choice->getValid()) {
                $nbAnswers++;
            }

            $i += 2;
        }
        
        if (count($question->getQuestionQCMChoices()) < 2) {
            throw new ParseException('Less than 2 qcm choices');
        }
        
        if (0 === $nbAnswers) {
            throw new ParseException('No valid qcm choice');
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
     * @param array $data
     */
    private function processFreeQuestion(Question $question, array $data)
    {
        $question
            ->setType(Question::TYPE_FREE)
            ->setFreeAnswer(trim($data[3]))
        ;
    }
    
    /**
     * Get topic number from number or key
     * 
     * @param string $key
     * 
     * @return integer
     */
    private function getTopicNumber($key)
    {
        if (is_numeric($key)) {
            $n = intval($key);
            
            if ($n < 1 || $n > 10) {
                throw new ParseException('Invalid topic number, expected number between 1 and 10, got "'.$n.'"');
            }
            
            return $n - 1;
        }
        
        switch (strtolower($key)) {
            case 'basic':
            case 'basics':
                return 0;

            case 'poo':
            case 'oop':
                return 1;

            case 'security':
                return 2;

            case 'function':
            case 'functions':
                return 3;

            case 'format':
                return 4;

            case 'web':
                return 5;

            case 'i/o':
                return 6;

            case 'strings':
                return 7;

            case 'db':
            case 'bdd':
            case 'databases':
                return 8;

            case 'array':
            case 'arrays':
                return 9;

            default:
                throw new ParseException('Unknown topic name "'.$key.'"');
        }
    }
}
