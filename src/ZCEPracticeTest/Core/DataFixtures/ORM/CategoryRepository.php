<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category DataFixtures
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\Core\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Core\Entity\Category;

class CategoryLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load default dataset of question
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setEntitled('Category ' . $i);
            $objectManager->persist($category);
            $this->addReference($category->getEntitled(), $category);
        }

        $objectManager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
