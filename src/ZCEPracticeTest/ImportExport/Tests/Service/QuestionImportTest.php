<?php

/**
 * PHP version 5.5
 *
 * @category Service
 * @package  ImportExport
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\ImportExport\Tests\Service;

use ZCEPracticeTest\Core\Entity\Topic;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Repository\TopicRepository;
use ZCEPracticeTest\ImportExport\Service\QuestionImport;

/**
 * Import questions
 *
 * @category Service
 * @package  ImportExport
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionImportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QuestionImport
     */
    private $questionImport;
    
    /**
     * Same data as first line of sample.csv
     * 
     * @var array
     */
    private $lineSample;
    
    /**
     * @var Topic[]
     */
    private $topics;
    
    public function __construct()
    {
        $this->createTopics();
        
        $topicRepository = $this->createMockedTopicRepository();
        $this->questionImport = new QuestionImport($topicRepository);
        
        $this->lineSample = array(
            'What is the output of the following code ?',
            '2',
            implode("\n", array('<?php', '$v = \'World\';', 'Echo \'Hello\'.$v;')),
            'Hello',
            'false',
            'Hello World',
            'false',
            'HelloWorld',
            'true',
            'Fatal Error',
            'false',
            '',
            '',
        );
    }
    
    /**
     * Create topics
     */
    private function createTopics()
    {
        $this->topics = array();
        
        $names = array(
            'PHP Basics',
            'Object Oriented Programming',
            'Security',
            'Functions',
            'Data Format & Types',
            'Web Features',
            'I/O',
            'Strings & Patterns',
            'Databases & SQL',
            'Arrays',
        );
        
        for ($i = 0; $i < 10; $i++) {
            $topic = new Topic();
            
            $topic->setIsPrimary($i < 3);
            $topic->setEntitled($names[$i]);
            
            $this->topics []= $topic;
        }
    }
    
    /**
     * Create a mocked topic repository
     * which will return topics
     * 
     * @return TopicRepository
     */
    private function createMockedTopicRepository()
    {
        $mock = $this
            ->getMockBuilder('\ZCEPracticeTest\Core\Repository\TopicRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('findBy'))
            ->getMock()
        ;
        
        $mock
            ->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue($this->topics))
        ;
        
        return $mock;
    }
    
    public function testProcessFile()
    {
        $file = fopen(dirname(__FILE__).'/../Samples/sample.csv', 'r');
        
        $questions = $this->questionImport->processFile($file);
        
        $this->assertInternalType('array', $questions);
        $this->assertCount(3, $questions);
        
        $this->assertEquals($this->lineSample[0], $questions[0]->getEntitled());
        $this->assertEquals($this->lineSample[2], $questions[0]->getCode());
        
        $this->assertEquals(Question::TYPE_QCM, $questions[0]->getType());
        $this->assertEquals(Question::TYPE_FREE, $questions[1]->getType());
        $this->assertEquals(Question::TYPE_QCM, $questions[2]->getType());
        
        $this->assertCount(4, $questions[0]->getQuestionQCMChoices());
        $this->assertCount(5, $questions[2]->getQuestionQCMChoices());
    }
    
    public function testProcessCsvLineReturnsQCMQuestion()
    {
        $question = $this->questionImport->processCsvLine($this->lineSample);
        
        $this->assertInstanceOf('\ZCEPracticeTest\Core\Entity\Question', $question);
        
        $this->assertEquals(Question::TYPE_QCM, $question->getType());
        $this->assertEquals($this->lineSample[0], $question->getEntitled());
        $this->assertEquals($this->topics[1]->getEntitled(), $question->getTopic()->getEntitled());
        $this->assertEquals($this->lineSample[2], $question->getCode());
        
        $choices = $question->getQuestionQCMChoices();
        
        $this->assertEquals(false, $choices[0]->getValid());
        $this->assertEquals(false, $choices[1]->getValid());
        $this->assertEquals(true, $choices[2]->getValid());
        $this->assertEquals(false, $choices[3]->getValid());
        
        $this->assertEquals($this->lineSample[3], $choices[0]->getEntitled());
        $this->assertEquals($this->lineSample[5], $choices[1]->getEntitled());
        $this->assertEquals($this->lineSample[7], $choices[2]->getEntitled());
        $this->assertEquals($this->lineSample[9], $choices[3]->getEntitled());
    }
    
    public function testProcessFileThrowNoChoice()
    {
        $file = fopen(dirname(__FILE__).'/../Samples/sampleErrNoChoice.csv', 'r');
        
        $this->setExpectedException(
            '\ZCEPracticeTest\ImportExport\Exception\ParseException',
            'Less than 2 qcm choices at question 3'
        );
        
        $this->questionImport->processFile($file);
    }
    
    public function testProcessFileThrowNoValidChoice()
    {
        $file = fopen(dirname(__FILE__).'/../Samples/sampleErrNoValidChoice.csv', 'r');
        
        $this->setExpectedException(
            '\ZCEPracticeTest\ImportExport\Exception\ParseException',
            'No valid qcm choice at question 1'
        );
        
        $this->questionImport->processFile($file);
    }
}
