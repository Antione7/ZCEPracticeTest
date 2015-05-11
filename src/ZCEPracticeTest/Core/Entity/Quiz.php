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
 * Quiz entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Quiz implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var QuizQuestion[]
     */
    private $quizQuestions;

    /**
     * @var Session[]
     */
    private $sessions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quizQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * 
     * @return Quiz
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
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

    /**
     * Set quizQuestions
     *
     * @return Quiz
     */
    public function setQuizQuestions($quizQuestions)
    {
        $this->quizQuestions = $quizQuestions;
        
        return $this;
    }

    /**
     * Add sessions
     *
     * @param Session $sessions
     * @return Quiz
     */
    public function addSession(Session $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param Session $sessions
     */
    public function removeSession(Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return Session[]
     */
    public function getSessions()
    {
        return $this->sessions;
    }
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $quizQuestions = array();
        
        foreach ($this->getQuizQuestions() as $quizQuestion) {
            $quizQuestions []= $quizQuestion->jsonSerialize();
        }
        
        return array(
            'id' => $this->getId(),
            'quizQuestions' => $quizQuestions,
        );
    }
}
