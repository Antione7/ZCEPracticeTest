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
namespace ZCEPracticeTest\Core\DataFixtures\Test;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Core\Entity\QuestionQCMChoice;

class QuestionQCMChoiceLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load default dataset of question
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        for ($i = 0; $i < 5; $i++) {
            $o = array(
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
            );
            
            $o[0]->setEntitled('Hello');
            $o[1]->setEntitled('Hello World');
            $o[2]->setEntitled('HelloWorld');
            $o[3]->setEntitled('A fatal error');
            
            $o[0]->setIsValid(false);
            $o[1]->setIsValid(false);
            $o[2]->setIsValid(true);
            $o[3]->setIsValid(false);
            
            for ($j = 0; $j < 4; $j++) {
                $o[$j]
                    ->setQuestion($this->getReference('question-qcm-'.$i))
                ;
                
                $objectManager->persist($o[$j]);
            }
        }

        $objectManager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
