<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Tests;

class Test extends \PHPUnit_Framework_TestCase
{
    public function testPass()
    {
        $this->assertEquals(1, 1);
    }
    
    public function testFail()
    {
        $this->assertEquals(1, 2);
    }
}
