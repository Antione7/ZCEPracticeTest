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
 * Session entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Session implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $success;

    /**
     * @var \DateTime
     */
    private $dateStart;

    /**
     * @var \DateTime
     */
    private $dateFinished;

    /**
     * @var integer
     */
    private $nbTopicsValidated;

    /**
     * @var Answer[]
     */
    private $answers;

    /**
     * @var TopicScore[]
     */
    private $topicScores;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Quiz
     */
    private $quiz;

    /**
     * Constructor
     */
    public function __construct()
    {
        //$oDate = new \DateTime();
        $oDate = new \DateTime('now', new \DateTimeZone('UTC'));

        $this->setDateStart($oDate);
        $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->topicScores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set success
     *
     * @param boolean $success
     * @return Session
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get success
     *
     * @return boolean 
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Session
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateFinished
     *
     * @param \DateTime $dateFinished
     * @return Session
     */
    public function setDateFinished($dateFinished)
    {
        $this->dateFinished = $dateFinished;

        return $this;
    }

    /**
     * Get dateFinished
     *
     * @return \DateTime 
     */
    public function getDateFinished()
    {
        return $this->dateFinished;
    }

    /**
     * Set nbTopicsValidated
     *
     * @param integer $nbTopicsValidated
     * @return Session
     */
    public function setNbTopicsValidated($nbTopicsValidated)
    {
        $this->nbTopicsValidated = $nbTopicsValidated;

        return $this;
    }

    /**
     * Get nbTopicsValidated
     *
     * @return integer 
     */
    public function getNbTopicsValidated()
    {
        return $this->nbTopicsValidated;
    }

    /**
     * Add answers
     *
     * @param Answer $answers
     * @return Session
     */
    public function addAnswer(Answer $answers)
    {
        $this->answers[] = $answers;

        return $this;
    }

    /**
     * Remove answers
     *
     * @param Answer $answers
     */
    public function removeAnswer(Answer $answers)
    {
        $this->answers->removeElement($answers);
    }

    /**
     * Get answers
     *
     * @return Answer[] 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Add topicScores
     *
     * @param TopicScore $topicScores
     * @return Session
     */
    public function addTopicScore(TopicScore $topicScores)
    {
        $this->topicScores[] = $topicScores;

        return $this;
    }

    /**
     * Remove topicScores
     *
     * @param TopicScore $topicScores
     */
    public function removeTopicScore(TopicScore $topicScores)
    {
        $this->topicScores->removeElement($topicScores);
    }

    /**
     * Get topicScores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTopicScores()
    {
        return $this->topicScores;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Session
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set quiz
     *
     * @param Quiz $quiz
     * @return Session
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
     * @return array
     */
    public function jsonSerialize()
    {
        $answers = array();
        
        foreach ($this->getAnswers() as $answer) {
            $answers []= $answer->jsonSerialize();
        }
        
        return array(
            'id' => $this->getId(),
            'success' => $this->getSuccess(),
            'dateStart' => $this->getDateStart(),
            'dateFinished' => $this->getDateFinished(),
            'nbTopicsValidated' => $this->getNbTopicsValidated(),
            'answers' => $answers,
            'user' => $this->getUser()->jsonSerialize(),
            'quiz' => $this->getQuiz()->jsonSerialize(),
        );
    }
}
