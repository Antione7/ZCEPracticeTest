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
namespace ZCEPracticeTest\Core\DataFixtures\Base;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Core\Entity\Topic;

class TopicLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load default dataset of question
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $objects = array(
            /**
             * Primary topics
             */
            'php-basics' => array(
                'PHP Basics',
                true,
            ),
            'object-oriented-programming' => array(
                'Object Oriented Programming',
                true,
            ),
            'security' => array(
                'Security',
                true,
            ),
            
            /**
             * Secondary topics
             */
            'functions' => array(
                'Functions',
                false,
            ),
            'data-format-types' => array(
                'Data Format & Types',
                false,
            ),
            'web-features' => array(
                'Web Features',
                false,
            ),
            'io' => array(
                'I/O',
                false,
            ),
            'strings-patterns' => array(
                'Strings & Patterns',
                false,
            ),
            'databases-sql' => array(
                'Databases & SQL',
                false,
            ),
            'arrays' => array(
                'Arrays',
                false,
            ),
        );
        
        foreach ($objects as $key => $object) {
            $o = new Topic();
            $o->setEntitled($object[0]);
            $o->setIsPrimary($object[1]);
            $this->addReference('topic-'.$key, $o);
            $objectManager->persist($o);
        }

        $objectManager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 0;
    }
}
