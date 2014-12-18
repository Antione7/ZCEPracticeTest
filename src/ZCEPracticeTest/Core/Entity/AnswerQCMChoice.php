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
 * AnswerQCMChoice entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class AnswerQCMChoice
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Answer
     */
    private $answer;

    /**
     * @var QuestionQCMChoice
     */
    private $questionQCMChoice;


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
     * Set answer
     *
     * @param Answer $answer
     * @return AnswerQCMChoice
     */
    public function setAnswer(Answer $answer = null)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return Answer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set questionQCMChoice
     *
     * @param QuestionQCMChoice $questionQCMChoice
     * @return AnswerQCMChoice
     */
    public function setQuestionQCMChoice(QuestionQCMChoice $questionQCMChoice = null)
    {
        $this->questionQCMChoice = $questionQCMChoice;

        return $this;
    }

    /**
     * Get questionQCMChoice
     *
     * @return QuestionQCMChoice 
     */
    public function getQuestionQCMChoice()
    {
        return $this->questionQCMChoice;
    }
}
