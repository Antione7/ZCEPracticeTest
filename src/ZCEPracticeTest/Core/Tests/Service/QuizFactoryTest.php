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

use ZCEPracticeTest\Core\Entity\Category;
use ZCEPracticeTest\Core\Entity\QuestionQCM;
use ZCEPracticeTest\Core\Entity\QuestionFree;
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
     * @var Category[]
     */
    private $categories;
    
    /**
     * @var Question[]
     */
    private $questions;
    
    public function __construct()
    {
        $this->quizFactory = new QuizFactory(new QuestionManager());
        
        $this->categories = array(
            (new Category())->setEntitled('Category 1'),
            (new Category())->setEntitled('Category 2'),
            (new Category())->setEntitled('Category 3'),
        );
        
        $this->questions = array();
        for ($i = 0; $i < 72; $i++) {
            if ($i % 2) {
                $question = new QuestionQCM();
            } else {
                $question = new QuestionFree();
            }
            
            $question->setCategory($this->categories[$i % 3]);
            $this->questions []= $question;
        }
    }
    
    public function testCreateQuizPercentagesTotalEquals1AndAreMultiples()
    {
        // Percentages set 1
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->categories[0], 0.50),
            array($this->categories[1], 0.25),
            array($this->categories[2], 0.25),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
        $this->assertEquals($counts[0], 12);
        $this->assertEquals($counts[1], 6);
        $this->assertEquals($counts[2], 6);
        
        // Percentages set 2
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->categories[0], 0.125),
            array($this->categories[1], 0.250),
            array($this->categories[2], 0.625),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
        $this->assertEquals($counts[0], 3);
        $this->assertEquals($counts[1], 6);
        $this->assertEquals($counts[2], 15);
    }
    
    public function testCreateQuizPercentagesTotalEquals24AndAreMultiples()
    {
        // Percentages set 1
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->categories[0], 8),
            array($this->categories[1], 8),
            array($this->categories[2], 8),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
        $this->assertEquals($counts[0], 8);
        $this->assertEquals($counts[1], 8);
        $this->assertEquals($counts[2], 8);
        
        // Percentages set 2
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 24, array(
            array($this->categories[0], 3),
            array($this->categories[1], 7),
            array($this->categories[2], 14),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
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
            array($this->categories[0], 0.8),
            array($this->categories[1], 0.1),
            array($this->categories[2], 0.1),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
        $this->assertCount(24, $quiz->getQuizQuestions());
        $this->assertGreaterThan(16, $counts[0]);
        $this->assertGreaterThan(0, $counts[1]);
        $this->assertGreaterThan($counts[1], $counts[0]);
    }
    
    public function testCreateQuizPercentagesMultiplesAndHaveSomeQuestions()
    {
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 10, array(
            array($this->categories[0], 4),
            array($this->categories[1], 3),
            array($this->categories[2], 3),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
        $this->assertEquals($counts[0], 4);
        $this->assertEquals($counts[1], 3);
        $this->assertEquals($counts[2], 3);
        
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 10, array(
            array($this->categories[0], 7),
            array($this->categories[1], 3),
            array($this->categories[2], 0),
        ));
        
        $counts = $this->countQuestionCategories($quiz);
        
        $this->assertEquals($counts[0], 7);
        $this->assertEquals($counts[1], 3);
        $this->assertEquals($counts[2], 0);
    }
    
    public function testCreateQuizWithNotEnoughQuestionInCategoryThrowsException()
    {
        $this->setExpectedException('\ZCEPracticeTest\Core\Exception\QuizFactoryException');
        
        $quiz = $this->quizFactory->createCategorizedRandomQuiz($this->questions, 10, array(
            array($this->categories[0], 4),
            array($this->categories[1], 3),
            array($this->categories[2], 3),
            array(new Category(), 3),
        ));
    }
    
    private function countQuestionCategories(Quiz $quiz)
    {
        $counts = array(0, 0, 0);
        
        foreach ($quiz->getQuizQuestions() as $quizQuestion) {
            $category = $quizQuestion->getQuestion()->getCategory();
            
            for ($i = 0; $i < 3; $i++) {
                if ($category === $this->categories[$i]) {
                    $counts[$i]++;
                    continue;
                }
            }
        }
        
        return $counts;
    }
}
