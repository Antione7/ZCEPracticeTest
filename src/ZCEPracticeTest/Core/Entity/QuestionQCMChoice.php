<?php

namespace ZCEPracticeTest\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionQCMChoice
 */
class QuestionQCMChoice
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $entitled;

    /**
     * @var boolean
     * 
     * @Assert\NotBlank()
     */
    private $isValid;

    /**
     * @var QuestionQCM
     */
    private $question;


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
     * Set entitled
     *
     * @param string $entitled
     * @return QuestionQCMChoice
     */
    public function setEntitled($entitled)
    {
        $this->entitled = $entitled;

        return $this;
    }

    /**
     * Get entitled
     *
     * @return string 
     */
    public function getEntitled()
    {
        return $this->entitled;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     * @return QuestionQCMChoice
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return boolean 
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set question
     *
     * @param QuestionQCM $question
     * @return QuestionQCMChoice
     */
    public function setQuestion(QuestionQCM $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return QuestionQCM
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Return to json format the answer entity
     * 
     * @return array
     */
    public function jsonSerialize ()
    {
        return array(
            'id' => $this->id,
            'entitled' => $this->entitled,
            'isValid' => $this->isValid,
        );
    }
}
