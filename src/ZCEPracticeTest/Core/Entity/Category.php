<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
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
 *
 * @Table(name="category")
 * @Entity(repositoryClass="ZCEPracticeTest\FrontBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * Id of category entity
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Entitled of category
     * @var string
     *
     * @Column(name="entitled", type="text")
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
