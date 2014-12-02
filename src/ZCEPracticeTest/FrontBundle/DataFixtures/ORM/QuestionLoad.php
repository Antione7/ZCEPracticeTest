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
namespace ZCEPracticeTest\FrontBundle\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZCEPracticeTest\FrontBundle\Entity\Answer;
use ZCEPracticeTest\FrontBundle\Entity\Question;

class QuestionLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load default dataset of question
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $category = $this->getReference('Category 0');
        $questionData = array(
            'entitled'  => "Question",
            'code'      => "<?php echo 'Hello world';",
        );

        $answerData = array(
            array(
                'entitled' => 'Answer',
                'isValid'  => true,
            ),
            array(
                'entitled' => 'Answer',
                'isValid'  => false,
            ),
        );

        // add 5 questions
        for ($i = 0; $i < 5; $i++) {
            $question = new Question();
            $question->setEntitled($questionData['entitled']);
            $question->setCode($questionData['code']);
            $question->setCategory($category);
            // add 2 answers per question
            for ($j = 0; $j < 2; $j++) {
                $answer = new Answer();
                $answer->setEntitled($answerData[$j]['entitled']);
                $answer->setIsValid($answerData[$j]['isValid']);
                $answer->setQuestion($question);
                $question->addAnswer($answer);
            }
            $objectManager->persist($question);
        }

        $objectManager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}