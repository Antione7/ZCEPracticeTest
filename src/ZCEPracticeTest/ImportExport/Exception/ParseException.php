<?php

/**
 * PHP version 5.5
 *
 * @category Exception
 * @package  ImportExport
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\ImportExport\Exception;

use ZCEPracticeTest\Core\Exception\ZCEPracticeTestException;

/**
 * @category Exception
 * @package  ImportExport
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class ParseException extends ZCEPracticeTestException
{
    public function __construct($message, $line = 0)
    {
        parent::__construct(($line > 0) ? $message.' at question '.$line : $message);
    }
}
