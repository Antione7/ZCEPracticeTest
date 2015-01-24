<?php

/**
 * PHP version 5.5
 *
 * @category Event
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event abstract.
 *
 * @category Event
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
abstract class EventAbstract extends Event
{
    const QUESTION_INIT = 'event.zce.questions.init';
    
    /**
     * Event dispatched when a session has been ended
     * and score data is received.
     * 
     * Listener receive a SessionEvent instance.
     * 
     * @var string
     */
    const SESSION_ENDED = 'event.zce.session.ended';
}
