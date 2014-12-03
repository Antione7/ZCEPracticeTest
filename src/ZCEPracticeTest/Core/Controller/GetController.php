<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Controller
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\Core\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\EventDispatcher\EventDispatcher;
use ZCEPracticeTest\Core\Event\QuestionEvent;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class GetController
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    
    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * @return JsonResponse
     */
    public function questionAction ()
    {
        // event initialize questions
        $questionEvent = new QuestionEvent(5);
        $this->eventDispatcher->dispatch(QuestionEvent::QUESTION_INIT, $questionEvent);

        return new JsonResponse($questionEvent->getJson());
    }
}
