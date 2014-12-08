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
use ZCEPracticeTest\Core\Entity\QuizQuestion;

class QuizQuestionLoad extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load default dataset of question
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $quizzes = array(0,0,1,1,1,1,1,0,0,0);
        $questions = array('free-0', 'free-1', 'qcm-0', 'qcm-1', 'qcm-2', 'qcm-3', 'qcm-4', 'free-2', 'free-3', 'free-4');
        
        for ($i = 0; $i < 10; $i++) {
            $o = new QuizQuestion();
            $quiz = $this->getReference('quiz-'.($quizzes[$i]));
            $question = $this->getReference('question-'.$questions[$i]);
            $o
                ->setQuiz($quiz)
                ->setQuestion($question)
            ;
            $objectManager->persist($o);
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
