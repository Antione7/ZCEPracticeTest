<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hack table, not used
 * 
 * Custom fields for user. Entity temporarly created
 * to not crash when SimpleUser request this table.
 *
 * @category Entity
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class UserCustomFields
{
    /**
     * @var integer
     */
    protected $userId;
}
