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
class UserException extends ZCEPracticeTestException
{
    public function __construct($message, $httpCode = 404)
    {
        parent::__construct($message, $httpCode, null);
    }
}
