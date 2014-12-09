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
     * @var AnswerQCM
     */
    private $answerQCM;

    /**
     * @var QuestionQCMChoice
     */
    private $session;


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
     * Set answerQCM
     *
     * @param AnswerQCM $answerQCM
     * @return AnswerQCMChoice
     */
    public function setAnswerQCM(AnswerQCM $answerQCM = null)
    {
        $this->answerQCM = $answerQCM;

        return $this;
    }

    /**
     * Get answerQCM
     *
     * @return AnswerQCM 
     */
    public function getAnswerQCM()
    {
        return $this->answerQCM;
    }

    /**
     * Set session
     *
     * @param QuestionQCMChoice $session
     * @return AnswerQCMChoice
     */
    public function setSession(QuestionQCMChoice $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return QuestionQCMChoice 
     */
    public function getSession()
    {
        return $this->session;
    }
}
