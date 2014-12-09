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
class QuestionManagerTest extends \PHPUnit_Framework_TestCase
{
    private $questionManager;
    
    private $categories;
    
    private $questions;
    
    public function __construct()
    {
        $this->questionManager = new QuestionManager();
        
        $this->categories = array(
            (new Category())->setEntitled('Category 1'),
            (new Category())->setEntitled('Category 2'),
            (new Category())->setEntitled('Category 3'),
        );
        
        $this->questions = array(
            (new QuestionQCM())->setCategory($this->categories[0]),
            
            (new QuestionQCM())->setCategory($this->categories[1]),
            (new QuestionQCM())->setCategory($this->categories[1]),
            (new QuestionFree())->setCategory($this->categories[1]),
            (new QuestionFree())->setCategory($this->categories[1]),
            
            (new QuestionQCM())->setCategory($this->categories[2]),
            (new QuestionQCM())->setCategory($this->categories[2]),
            (new QuestionQCM())->setCategory($this->categories[2]),
            (new QuestionFree())->setCategory($this->categories[2]),
            (new QuestionFree())->setCategory($this->categories[2]),
            (new QuestionQCM())->setCategory($this->categories[2]),
            (new QuestionQCM())->setCategory($this->categories[2]),
        );
    }
    
    public function testSortQuestionByCategories()
    {
        $category0 = $this->categories[0];
        $category1 = $this->categories[1];
        $category2 = $this->categories[2];
        
        $categories = $this->questionManager->sortQuestionsByCategories($this->questions);
        
        $this->assertCount(3, $categories);
        $this->assertCount(1, $categories[$category0]);
        $this->assertCount(4, $categories[$category1]);
        $this->assertCount(7, $categories[$category2]);
        $this->assertEquals($categories[$category0][0]->getCategory(), $category0);
        $this->assertEquals($categories[$category1][0]->getCategory(), $category1);
        $this->assertEquals($categories[$category1][3]->getCategory(), $category1);
        $this->assertEquals($categories[$category2][0]->getCategory(), $category2);
        $this->assertEquals($categories[$category2][6]->getCategory(), $category2);
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
