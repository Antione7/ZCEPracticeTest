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

use SplObjectStorage;
use ZCEPracticeTest\Core\Exception\ZCEPracticeTestException;
use ZCEPracticeTest\Core\Entity\Question;

/**
 * Question manager service.
 * 
 * Contains helper functions about question
 * or array of questions.
 *
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionManager
{
    /**
     * Return an SplObjectStorage with topics as indexes,
     * and questions as values
     * 
     * @param Question[] $questions
     * 
     * @return SplObjectStorage
     */
    public function sortQuestionsByTopics(array $questions)
    {
        $sortedQuestions = new SplObjectStorage();
        
        foreach ($questions as $question) {
            if (!isset($sortedQuestions[$question->getTopic()])) {
                $array = array();
            } else {
                $array = $sortedQuestions[$question->getTopic()];
            }
            
            $array []= $question;
            $sortedQuestions[$question->getTopic()] = $array;
        }
        
        return $sortedQuestions;
    }
    
    /**
     * Get n random questions
     * 
     * @param Question[] $questions
     * @param integer $num
     * 
     * @return Question[]
     * 
     * @throws ZCEPracticeTestException if there is not enough questions
     */
    public function getRandomQuestions(array $questions, $num)
    {
        $countQuestions = count($questions);
        
        if ($num > $countQuestions) {
            throw new ZCEPracticeTestException(sprintf(
                'Not enough questions to create this random quiz of size %n',
                $num
            ));
        }
        
        if ($countQuestions == $num) {
            return $questions;
        }
        
        if (0 == $num) {
            return array();
        }
        
        $randomKeys = array_rand($questions, $num);
        
        if (1 == $num) {
            $randomKeys = array($randomKeys);
        }
        
        $randomQuestions = array();
        
        foreach ($randomKeys as $key) {
            $randomQuestions []= $questions[$key];
        }
        
        return $randomQuestions;
    }
}
