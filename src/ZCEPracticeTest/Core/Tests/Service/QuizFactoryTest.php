<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Core\Tests\Service;

use ZCEPracticeTest\Core\Entity\Topic;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Entity\Quiz;
use ZCEPracticeTest\Core\Service\QuestionManager;
use ZCEPracticeTest\Core\Service\QuizFactory;

/**
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuizFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuizFactory
     */
    private $quizFactory;
    
    /**
     * @var Topic[]
     */
    private $topics;
    
    /**
     * @var Question[]
     */
    private $questions;
    
    public function __construct()
    {
        $this->quizFactory = new QuizFactory(new QuestionManager());
        
        $this->topics = array(
            (new Topic())->setEntitled('Topic 1'),
            (new Topic())->setEntitled('Topic 2'),
            (new Topic())->setEntitled('Topic 3'),
        );
        
        $this->questions = array();
        for ($i = 0; $i < 72; $i++) {
            $question = new Question();
            $question->setTopic($this->topics[$i % 3]);
            $this->questions []= $question;
        }
    }
    
    public function testCreateQuizPercentagesTotalEquals1AndAreMultiples()
    {
        // Percentages set 1
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->topics[0], 0.50),
            array($this->topics[1], 0.25),
            array($this->topics[2], 0.25),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertEquals($counts[0], 12);
        $this->assertEquals($counts[1], 6);
        $this->assertEquals($counts[2], 6);
        
        // Percentages set 2
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->topics[0], 0.125),
            array($this->topics[1], 0.250),
            array($this->topics[2], 0.625),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertEquals($counts[0], 3);
        $this->assertEquals($counts[1], 6);
        $this->assertEquals($counts[2], 15);
    }
    
    public function testCreateQuizPercentagesTotalEquals24AndAreMultiples()
    {
        // Percentages set 1
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->topics[0], 8),
            array($this->topics[1], 8),
            array($this->topics[2], 8),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertEquals($counts[0], 8);
        $this->assertEquals($counts[1], 8);
        $this->assertEquals($counts[2], 8);
        
        // Percentages set 2
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->topics[0], 3),
            array($this->topics[1], 7),
            array($this->topics[2], 14),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertEquals($counts[0], 3);
        $this->assertEquals($counts[1], 7);
        $this->assertEquals($counts[2], 14);
    }
    
    /**
     * In this case, there is a risk that because of rounding floats,
     * There is few questions missing at the end
     */
    public function testCreateQuizPercentagesDivisionRestIsNotForgotten()
    {
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->topics[0], 0.8),
            array($this->topics[1], 0.1),
            array($this->topics[2], 0.1),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertCount(24, $quiz->getQuizQuestions());
        $this->assertGreaterThan(16, $counts[0]);
        $this->assertGreaterThan(0, $counts[1]);
        $this->assertGreaterThan($counts[1], $counts[0]);
    }
    
    public function testCreateQuizPercentagesMultiplesAndHaveSomeQuestions()
    {
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 10, array(
            array($this->topics[0], 4),
            array($this->topics[1], 3),
            array($this->topics[2], 3),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertEquals($counts[0], 4);
        $this->assertEquals($counts[1], 3);
        $this->assertEquals($counts[2], 3);
        
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 10, array(
            array($this->topics[0], 7),
            array($this->topics[1], 3),
            array($this->topics[2], 0),
        ));
        
        $counts = $this->countQuestionTopics($quiz);
        
        $this->assertEquals($counts[0], 7);
        $this->assertEquals($counts[1], 3);
        $this->assertEquals($counts[2], 0);
    }
    
    public function testCreateQuizWithNotEnoughQuestionInTopicThrowsException()
    {
        $this->setExpectedException('\ZCEPracticeTest\Core\Exception\QuizFactoryException');
        
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 10, array(
            array($this->topics[0], 4),
            array($this->topics[1], 3),
            array($this->topics[2], 3),
            array(new Topic(), 3),
        ));
    }
    
    private function countQuestionTopics(Quiz $quiz)
    {
        $counts = array(0, 0, 0);
        
        foreach ($quiz->getQuizQuestions() as $quizQuestion) {
            $topic = $quizQuestion->getQuestion()->getTopic();
            
            for ($i = 0; $i < 3; $i++) {
                if ($topic === $this->topics[$i]) {
                    $counts[$i]++;
                    continue;
                }
            }
        }
        
        return $counts;
    }
}
