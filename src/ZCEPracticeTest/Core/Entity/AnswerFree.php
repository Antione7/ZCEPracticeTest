<?php

namespace ZCEPracticeTest\Core\Entity;

/**
 * AnswerFree
 */
class AnswerFree
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $answer;


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
     * @param string $answer
     * @return AnswerFree
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string 
     */
    public function getAnswer()
    {
        return $this->answer;
    }
}
