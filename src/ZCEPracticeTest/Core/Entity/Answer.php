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
abstract class Answer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $tagged;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var Question
     */
    private $question;

    /**
     * @var Session
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
}
