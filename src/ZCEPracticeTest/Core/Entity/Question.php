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
class Question implements \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;

    /**
     * Entitled of question
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
     * Code of question to display through as colored syntax,
     * not required
     * 
     * @var string
     *
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $code;

    /**
     * Expected free answer
     * 
     * @var string
     */
    private $freeAnswer;

    /**
     * @var integer
     */
    private $nbAnswers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionQCMChoices;

    /**
     * @var Topic
     */
    private $topic;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionQCMChoices = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set type
     *
     * @param integer $type
     * @return Question
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set entitled
     *
     * @param string $entitled
     * @return Question
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
     * Set code
     *
     * @param string $code
     * @return Question
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set freeAnswer
     *
     * @param string $freeAnswer
     * @return Question
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
     * Set nbAnswers
     *
     * @param integer $nbAnswers
     * @return Question
     */
    public function setNbAnswers($nbAnswers)
    {
        $this->nbAnswers = $nbAnswers;

        return $this;
    }

    /**
     * Get nbAnswers
     *
     * @return integer 
     */
    public function getNbAnswers()
    {
        return $this->nbAnswers;
    }

    /**
     * Add questionQCMChoices
     *
     * @param QuestionQCMChoice $questionQCMChoices
     * @return Question
     */
    public function addQuestionQCMChoice(QuestionQCMChoice $questionQCMChoices)
    {
        $this->questionQCMChoices[] = $questionQCMChoices;

        return $this;
    }

    /**
     * Get questionQCMChoices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestionQCMChoices()
    {
        return $this->questionQCMChoices;
    }

    /**
     * Set topic
     *
     * @param Topic $topic
     * @return Question
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
    
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'entitled' => $this->getEntitled(),
            'code' => $this->getCode(),
            'category' => $this->getCategory(),
        );
    }
}
