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
}
