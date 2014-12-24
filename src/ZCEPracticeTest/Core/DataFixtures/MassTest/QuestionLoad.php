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
namespace ZCEPracticeTest\Core\DataFixtures\MassTest;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\Core\Entity\Question;

class QuestionFreeLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load default dataset of question
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $code = <<<'CODE'
<?php
$v = 'World';
echo 'Hello'.$v;
CODE;
        
        for ($i = 5; $i < 500; $i++) {
            $o = new Question();
            
            $o
                ->setType(Question::TYPE_QCM)
                ->setEntitled(($i+1).') What is the output of the following code ?')
                ->setCode($code)
                ->setTopic($this->getReference('topic-'.($i % 10)))
                ->setNbAnswers(1)
            ;
            
            $this->addReference('question-qcm-'.$i, $o);
            $objectManager->persist($o);
        }
        
        for ($i = 5; $i < 500; $i++) {
            $o = new Question();
            
            $o
                ->setType(Question::TYPE_FREE)
                ->setEntitled(($i+1).') Which function opens a handler on a file ?')
                ->setFreeAnswer('fopen')
                ->setTopic($this->getReference('topic-'.($i % 10)))
            ;
            
            $this->addReference('question-free-'.$i, $o);
            $objectManager->persist($o);
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
