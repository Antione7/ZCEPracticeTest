<?php

namespace ZCEPracticeTest\Core\Entity;

/**
 * TopicScore
 */
class TopicScore
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
     * @var Session
     */
    private $session;

    /**
     * @var Topic
     */
    private $topic;


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
     * 
     * @return TopicScore
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
     * Set session
     *
     * @param Session $session
     * 
     * @return TopicScore
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
     * Set topic
     *
     * @param Topic $topic
     * 
     * @return TopicScore
     */
    public function setTopic(Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return Topic 
     */
    public function getTopic()
    {
        return $this->topic;
    }
}
