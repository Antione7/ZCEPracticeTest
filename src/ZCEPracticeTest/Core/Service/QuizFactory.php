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
namespace ZCEPracticeTest\Core\Service;

use SplObjectStorage;
use ZCEPracticeTest\Core\Exception\QuizFactoryException;
use ZCEPracticeTest\Core\Entity\Category;
use ZCEPracticeTest\Core\Entity\Question;
use ZCEPracticeTest\Core\Entity\Quiz;
use ZCEPracticeTest\Core\Service\QuestionManager;
use ZCEPracticeTest\Core\QuizBuilder;

/**
 * Quiz factory service.
 * 
 * Create random quizzes with categorized questions.
 *
 * @category Service
 * @package  Core
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuizFactory
{
    /**
     * @var QuestionManager
     */
    private $questionManager;
    
    /**
     * @param QuestionManager $questionManager
     */
    public function __construct(QuestionManager $questionManager)
    {
        $this->questionManager = $questionManager;
    }
    
    /**
     * Create a random quiz with $quizSize questions from $questions
     * 
     * @param Question[] $questions
     * @param integer $quizSize
     * 
     * @return Quiz
     */
    public function createRandomQuiz(array $questions, $quizSize)
    {
        $quizBuilder = new QuizBuilder();
        
        $randomQuestions = $this->questionManager->getRandomQuestions($questions, $quizSize);
        
        $quizBuilder->addQuestions($randomQuestions);

        return $quizBuilder->getQuiz();
    }
    
    /**
     * Create a quiz of questions as a quiz.
     * Defines which categories you want and how much:
     * 
     * $quiz = $quizFactory->createCategorizedRandomQuiz($questionRepository->findAll(), 70, array(
     *      array($category0, $percentage0),
     *      array($category1, $percentage1),
     *      array($category2, $percentage2),
     * ));
     * 
     * @param Question[] $questions to use
     * @param integer $quizSize number of questions to put in quiz
     * @param array $percentages of questions of each categories
     * 
     * @return Quiz
     * 
     * @throws QuizFactoryException if there is not enough questions in a category
     */
    public function createCategorizedRandomQuiz(array $questions, $quizSize, array $percentages)
    {
        $this->checkPercentages($percentages);
        
        $quizBuilder = new QuizBuilder();
        $numberOfQuestions = $this->calculateNumberQuestionsPerCategories($quizSize, $percentages);
        $categorizedQuestions = $this->questionManager->sortQuestionsByCategories($questions);
        
        foreach ($percentages as $percentage) {
            $category = $percentage[0];
            
            if (!isset($categorizedQuestions[$category])) {
                throw new QuizFactoryException('No any questions in category '.$category->getEntitled());
            }
            
            $size = $numberOfQuestions[$category];
            $candidates = $categorizedQuestions[$category];
            
            try {
                $randomQuestions = $this->questionManager->getRandomQuestions($candidates, $size);
            } catch (ZCEPracticeTestException $ex) {
                throw new QuizFactoryException($ex->getMessage().' in category '.$category->getEntitled());
            }
            
            $quizBuilder->addQuestions($randomQuestions);
        }
        
        return $quizBuilder->getQuiz();
    }
    
    /**
     * Convert percentages per categories to a number of questions.
     * Fill with random categories if sum of rounded numbers is not enough.
     * 
     * @param integer $quizSize
     * @param array $percentages
     * 
     * @return Question[]
     */
    private function calculateNumberQuestionsPerCategories($quizSize, array $percentages)
    {
        $questionsNumber = new SplObjectStorage();
        $sum = $this->getPercentagesSum($percentages);
        $size = 0;
        
        foreach ($percentages as $percentage) {
            $category = $percentage[0];
            $value = $percentage[1];
            
            $questionsNumber[$category] = floor(($quizSize * $value) / $sum);
            
            $size += $questionsNumber[$category];
        }
        
        $questionsNumber->rewind();

        while ($size < $quizSize) {
            $n = $questionsNumber[$questionsNumber->current()];
            $n++;
            $questionsNumber[$questionsNumber->current()] = $n;

            $size++;
        }
        
        return $questionsNumber;
    }
    
    /**
     * Calculate sum of percentages
     * 
     * @param array $percentages
     * 
     * @return double
     * 
     * @throws QuizFactoryException if a percentage is not numeric
     */
    private function getPercentagesSum(array $percentages)
    {
        $sum = 0;
        
        foreach ($percentages as $percentage) {
            $sum += $percentage[1];
        }
        
        return $sum;
    }
    
    /**
     * Check if percentages array is well formed
     * (array of [Category, double])
     * 
     * @param array $percentages
     * 
     * @throws QuizFactoryException
     */
    private function checkPercentages(array $percentages)
    {
        foreach ($percentages as $percentage) {
            if (!($percentage[0] instanceof Category)) {
                throw new QuizFactoryException(sprintf(
                    'percentages must be an array of [category, number]. Got instance of "%s" as category',
                    get_class($percentage[0])
                ));
            }
            
            if (!is_numeric($percentage[1])) {
                throw new QuizFactoryException(sprintf(
                    'percentages must be an array of [category, number]. Got "%s" as number',
                    $percentage[1]
                ));
            }
        }
    }
}
