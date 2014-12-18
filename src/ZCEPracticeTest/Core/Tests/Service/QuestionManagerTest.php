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

use ZCEPracticeTest\Core\Exception\ZCEPracticeTestException;
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
class QuestionManagerTest extends \PHPUnit_Framework_TestCase
{
    private $questionManager;
    
    private $topics;
    
    private $questions;
    
    public function __construct()
    {
        $this->questionManager = new QuestionManager();
        
        $this->topics = array(
            (new Topic())->setEntitled('Topic 1'),
            (new Topic())->setEntitled('Topic 2'),
            (new Topic())->setEntitled('Topic 3'),
        );
        
        $this->questions = array(
            (new Question())->setTopic($this->topics[0]),
            
            (new Question())->setTopic($this->topics[1]),
            (new Question())->setTopic($this->topics[1]),
            (new Question())->setTopic($this->topics[1]),
            (new Question())->setTopic($this->topics[1]),
            
            (new Question())->setTopic($this->topics[2]),
            (new Question())->setTopic($this->topics[2]),
            (new Question())->setTopic($this->topics[2]),
            (new Question())->setTopic($this->topics[2]),
            (new Question())->setTopic($this->topics[2]),
            (new Question())->setTopic($this->topics[2]),
            (new Question())->setTopic($this->topics[2]),
        );
    }
    
    public function testSortQuestionByTopics()
    {
        $topic0 = $this->topics[0];
        $topic1 = $this->topics[1];
        $topic2 = $this->topics[2];
        
        $topics = $this->questionManager->sortQuestionsByTopics($this->questions);
        
        $this->assertCount(3, $topics);
        $this->assertCount(1, $topics[$topic0]);
        $this->assertCount(4, $topics[$topic1]);
        $this->assertCount(7, $topics[$topic2]);
        $this->assertEquals($topics[$topic0][0]->getTopic(), $topic0);
        $this->assertEquals($topics[$topic1][0]->getTopic(), $topic1);
        $this->assertEquals($topics[$topic1][3]->getTopic(), $topic1);
        $this->assertEquals($topics[$topic2][0]->getTopic(), $topic2);
        $this->assertEquals($topics[$topic2][6]->getTopic(), $topic2);
    }
    
    public function testGetRandomsQuestions()
    {
        $randomQuestions = $this->questionManager->getRandomQuestions($this->questions, 5);
        
        $this->assertCount(5, $randomQuestions);
    }
    
    public function testGetRandomsQuestionsThrowsExceptionIfNotEnoughQuestions()
    {
        $this->setExpectedException('\ZCEPracticeTest\Core\Exception\ZCEPracticeTestException');
        
        $this->questionManager->getRandomQuestions($this->questions, 69);
    }
}
