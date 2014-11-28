<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Listener
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\FrontBundle\Listener;
use ZCEPracticeTest\FrontBundle\Event\QuestionEvent;

/**
 * Question Listener.
 * This listener used to respond to questions treatment processing.
 *
 * @category Listener
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionListener
{
    /**
     * Initialize questions
     * Get 70 questions randomly, parse them to json and set into event
     *
     * @param QuestionEvent $event
     */
    public function onQuestionsInit (QuestionEvent $event)
    {
        $questions = array();

        // get questions (@todo Entity call)

        // parse to json (@todo Service)


        $event->setQuestions($questions);
    }
}