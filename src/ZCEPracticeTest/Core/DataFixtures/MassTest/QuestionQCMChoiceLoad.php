<?php

/**
 * PHP version 5.5
 *
 * @category DataFixtures
 * @package  Core
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\DataFixtures\MassTest;

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
        for ($i = 5; $i < 500; $i++) {
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
            
            $o[0]->setValid(false);
            $o[1]->setValid(false);
            $o[2]->setValid(true);
            $o[3]->setValid(false);
            
            for ($j = 0; $j < 4; $j++) {
                $o[$j]
                    ->setQuestion($this->getReference('question-qcm-'.$i))
                ;
                
                $objectManager->persist($o[$j]);
            }
        }
        
        for ($i = 5; $i < 500; $i++) {
            $o = array(
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
                new QuestionQCMChoice(),
            );
            
            $o[0]->setEntitled('$MYVAR');
            $o[1]->setEntitled('$_myVar');
            $o[2]->setEntitled('$my-var');
            $o[3]->setEntitled('$3x');
            $o[4]->setEntitled('$my3Var_');
            
            $o[0]->setValid(true);
            $o[1]->setValid(true);
            $o[2]->setValid(false);
            $o[3]->setValid(false);
            $o[4]->setValid(true);
            
            for ($j = 0; $j < 5; $j++) {
                $o[$j]
                    ->setQuestion($this->getReference('question-qcm-multiple-'.$i))
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
