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
use Doctrine\ORM\EntityManager;
use ZCEPracticeTest\FrontBundle\Service\QuestionParser;

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
    protected $entityManager;

    protected $questionParser;

    public function __construct(EntityManager $entityManager, QuestionParser $questionParser)
    {
        $this->entityManager = $entityManager;
        $this->questionParser = $questionParser;
    }

    /**
     * Initialize questions
     * Get 70 questions randomly, parse them to json and set into event
     *
     * @param QuestionEvent $event
     */
    public function onQuestionsInit (QuestionEvent $event)
    {
        // get questions
        $questions =
            $this->entityManager->getRepository('ZCEPracticeTestFrontBundle:Question')
                 ->findBy(array(), array(), $event->getLimit());

        // parse to json
        $json = $this->questionParser->parseToJson($questions);

        $event->setJson($json);
    }
}