<?php

/**
 * PHP version 5.5
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Category entity
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class Category
{
    /**
     * Id of category entity
     * 
     * @var integer
     */
    private $id;

    /**
     * Entitled of category
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max="200"
     * )
     */
    private $entitled;

    /**
     * @param string $entitled
     */
    public function setEntitled($entitled)
    {
        $this->entitled = $entitled;
    }

    /**
     * @return string
     */
    public function getEntitled()
    {
        return $this->entitled;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
