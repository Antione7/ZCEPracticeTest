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
 * Category entity
 *
 * @category Entity
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Category
{
    /**
     * Id of category entity
     * 
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $entitled;

    /**
     * @var Question[]
     */
    private $questions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set entitled
     *
     * @param string $entitled
     * 
     * @return Category
     */
    public function setEntitled(string $entitled)
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
     * Add questions
     *
     * @param Question $questions
     * 
     * @return Category
     */
    public function addQuestion(Question $questions)
    {
        $this->questions[] = $questions;

        return $this;
    }

    /**
     * Remove questions
     *
     * @param Question $questions
     */
    public function removeQuestion(Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}
