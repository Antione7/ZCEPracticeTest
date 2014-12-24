<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Entity;

/**
 * Answer entity
 *
 * @category Entity
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Answer implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $freeAnswer;

    /**
     * @var boolean
     */
    private $tagged;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var AnswerQCMChoice[]
     */
    private $answerQCMChoices;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Session
     */
    private $session;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answerQCMChoices = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set freeAnswer
     *
     * @param string $freeAnswer
     * @return Answer
     */
    public function setFreeAnswer($freeAnswer)
    {
        $this->freeAnswer = $freeAnswer;

        return $this;
    }

    /**
     * Get freeAnswer
     *
     * @return string 
     */
    public function getFreeAnswer()
    {
        return $this->freeAnswer;
    }

    /**
     * Set tagged
     *
     * @param boolean $tagged
     * @return Answer
     */
    public function setTagged($tagged)
    {
        $this->tagged = $tagged;

        return $this;
    }

    /**
     * Get tagged
     *
     * @return boolean 
     */
    public function getTagged()
    {
        return $this->tagged;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Answer
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add answerQCMChoices
     *
     * @param AnswerQCMChoice $answerQCMChoices
     * @return Answer
     */
    public function addAnswerQCMChoice(AnswerQCMChoice $answerQCMChoices)
    {
        $this->answerQCMChoices[] = $answerQCMChoices;

        return $this;
    }

    /**
     * Get answerQCMChoices
     *
     * @return AnswerQCMChoice[] 
     */
    public function getAnswerQCMChoices()
    {
        return $this->answerQCMChoices;
    }

    /**
     * Set question
     *
     * @param Question $question
     * @return Answer
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

    /**
     * Set session
     *
     * @param Session $session
     * @return Answer
     */
    public function setSession(Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return Session 
     */
    public function getSession()
    {
        return $this->session;
    }
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $answerQCMChoices = array();
        
        foreach ($this->getAnswerQCMChoices() as $answerQCMChoice) {
            $answerQCMChoices []= $answerQCMChoice->jsonSerialize();
        }
        
        return array(
            'id' => $this->getId(),
            'freeAnswer' => $this->getFreeAnswer(),
            'tagged' => $this->getTagged(),
            'dateCreated' => $this->getDateCreated(),
            'answerQCMChoices' => $answerQCMChoices,
            'question' => $this->getQuestion()->jsonSerialize(),
        );
    }
}
