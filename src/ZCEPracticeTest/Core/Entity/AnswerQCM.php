<?php

namespace ZCEPracticeTest\Core\Entity;

/**
 * AnswerQCM
 */
class AnswerQCM extends Answer
{
    /**
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
