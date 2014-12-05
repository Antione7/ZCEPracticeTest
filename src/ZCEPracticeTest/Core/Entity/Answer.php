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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question entity
 *
 * @category Entity
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Answer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * Answer's Entitled
     * 
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $entitled;

    /**
     * Answer's value
     * 
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
     * @return Answer
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
     * @return Answer
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
     * @return Answer
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
