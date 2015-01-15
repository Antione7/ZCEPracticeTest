<?php

/**
 * PHP version 5.5
 *
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core;

use Doctrine\Common\Collections\ArrayCollection;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Entity\Quiz;
use ZCEPracticeTest\Core\Entity\QuizQuestion;

/**
 * Quiz manager service.
 * 
 * Contains helper functions about quiz.
 *
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuizBuilder
{
    /**
     * @var Quiz
     */
    private $quiz;
    
    /**
     * @param Quiz $quiz to start from
     */
    public function __construct(Quiz $quiz = null)
    {
        if (null === $quiz) {
            $this->quiz = new Quiz();
        } else {
            $this->quiz = $quiz;
        }
    }
    
    /**
     * @param Question $question
     */
    public function addQuestion(Question $question)
    {
        $quizQuestion = new QuizQuestion();
        
        $quizQuestion
            ->setQuiz($this->quiz)
            ->setQuestion($question)
        ;
        
        $this->quiz->addQuizQuestion($quizQuestion);
    }
    
    /**
     * @param Question[] $questions
     */
    public function addQuestions(array $questions)
    {
        foreach ($questions as $question) {
            $this->addQuestion($question);
        }
    }
    
    /**
     * Shuffle an array preserving keys
     * 
     * @param array $array
     * 
     * @return QuizBuilder
     */
    public function shuffleQuestions()
    {
        $array = $this->getQuiz()->getQuizQuestions()->toArray();
        
        $keys = array_keys($array);

        shuffle($keys);
        
        $new = new ArrayCollection();

        foreach ($keys as $key) {
            $new[$key] = $array[$key];
        }

        $this->getQuiz()->setQuizQuestions($new);

        return $this;
    }
    
    /**
     * @return Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }
}
