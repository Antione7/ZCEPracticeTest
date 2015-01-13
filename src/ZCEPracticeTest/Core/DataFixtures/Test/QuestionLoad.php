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
namespace ZCEPracticeTest\Core\DataFixtures\Test;

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
        
        for ($i = 0; $i < 5; $i++) {
            $o = new Question();
            
            $o
                ->setType(Question::TYPE_QCM)
                ->setEntitled('What is the output of the following code ?')
                ->setCode($code)
                ->setTopic($this->getReference('topic-php-basics'))
                ->setNbAnswers(1)
            ;
            
            $this->addReference('question-qcm-'.$i, $o);
            $objectManager->persist($o);
        }
        
        for ($i = 0; $i < 5; $i++) {
            $o = new Question();
            
            $o
                ->setType(Question::TYPE_FREE)
                ->setEntitled('Which function opens a handler on a file ?')
                ->setFreeAnswer('fopen')
                ->setTopic($this->getReference('topic-io'))
            ;
            
            $this->addReference('question-free-'.$i, $o);
            $objectManager->persist($o);
        }
        
        for ($i = 0; $i < 5; $i++) {
            $o = new Question();
            
            $o
                ->setType(Question::TYPE_QCM)
                ->setEntitled('Which variable name is valid ?')
                ->setTopic($this->getReference('topic-php-basics'))
                ->setNbAnswers(3)
            ;
            
            $this->addReference('question-qcm-multiple-'.$i, $o);
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
