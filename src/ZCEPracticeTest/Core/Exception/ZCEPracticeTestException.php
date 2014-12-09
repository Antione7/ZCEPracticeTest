<?php

/**
 * PHP version 5.5
 *
 * @category Exception
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Exception;

/**
 * Base exception for ZCE Practice test application.
 *
 * @category Exception
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class ZCEPracticeTestException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 0, null);
    }
}
