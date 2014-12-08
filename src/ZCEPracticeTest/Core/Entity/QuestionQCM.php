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

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question QCM entity
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionQCM extends Question
{
    /**
     * Minimum amount of choices to be checked
     * 
     * @var integer
     */
    private $min;

    /**
     * Maximum amount of choices to be checked
     * (Set 0 to disable max)
     * 
     * @var integer
     */
    private $max;

    /**
     * @var QuestionQCMChoice[]
     */
    private $questionQCMChoices;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setMin(0);
        $this->setMax(0);
        $this->questionQCMChoices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set min
     *
     * @param integer $min
     * 
     * @return QuestionQCM
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get min
     *
     * @return integer 
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     * 
     * @return QuestionQCM
     */
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Get max
     *
     * @return integer 
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Add questionQCMChoices
     *
     * @param QuestionQCMChoice $questionQCMChoices
     * 
     * @return QuestionQCM
     */
    public function addQuestionQCMChoice(QuestionQCMChoice $questionQCMChoice)
    {
        $this->questionQCMChoices[] = $questionQCMChoice;

        return $this;
    }

    /**
     * Remove questionQCMChoices
     *
     * @param QuestionQCMChoice $questionQCMChoices
     */
    public function removeQuestionQCMChoice(QuestionQCMChoice $questionQCMChoices)
    {
        $this->questionQCMChoices->removeElement($questionQCMChoices);
    }

    /**
     * Get questionQCMChoices
     *
     * @return QuestionQCMChoice[]
     */
    public function getQuestionQCMChoices()
    {
        return $this->questionQCMChoices;
    }
}
