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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Quiz entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Quiz
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var QuizQuestion[]
     */
    private $quizQuestions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quizQuestions = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add quizQuestions
     *
     * @param QuizQuestion $quizQuestions
     * @return Quiz
     */
    public function addQuizQuestion(QuizQuestion $quizQuestions)
    {
        $this->quizQuestions[] = $quizQuestions;

        return $this;
    }

    /**
     * Remove quizQuestions
     *
     * @param QuizQuestion $quizQuestions
     */
    public function removeQuizQuestion(QuizQuestion $quizQuestions)
    {
        $this->quizQuestions->removeElement($quizQuestions);
    }

    /**
     * Get quizQuestions
     *
     * @return QuizQuestion[]
     */
    public function getQuizQuestions()
    {
        return $this->quizQuestions;
    }
}
