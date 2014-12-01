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
namespace ZCEPracticeTest\FrontBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category entity
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="ZCEPracticeTest\FrontBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * Id of category entity
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Entitled of category
     * @var string
     *
     * @ORM\Column(name="entitled", type="text")
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