<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Entity;

/**
 * QuizQuestion entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuizQuestion implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Quiz
     */
    private $quiz;

    /**
     * @var Question
     */
    private $question;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quiz
     *
     * @param Quiz $quiz
     * @return QuizQuestion
     */
    public function setQuiz(Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set question
     *
     * @param Question $question
     * 
     * @return QuizQuestion
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    public function jsonSerialize()
    {
        return array(
            'question' => $this->getQuestion()->jsonSerialize(),
        );
    }
}
