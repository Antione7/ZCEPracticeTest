<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Event
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\FrontBundle\Event;

use ZCEPracticeTest\FrontBundle\Event\EventAbstract;

/**
 * Event abstract.
 *
 * @category Event
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionEvent extends EventAbstract
{
    private $questions;

    /**
     * Set questions in event
     * @param array $questions
     */
    public function setQuestions (array $questions)
    {
        $this->questions = $questions;
    }

    /**
     * Get questions in event
     * @return array
     */
    public function getQuestions()
    {
        return $this->questions;
    }
}