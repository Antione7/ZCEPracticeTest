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
use ZCEPracticeTest\Core\Entity\Topic;
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

        return $quizBuilder->shuffleQuestions()->getQuiz();
    }
    
    /**
     * Create a quiz of questions as a quiz.
     * Defines which topics you want and how much:
     * 
     * $quiz = $quizFactory->createCategorizedRandomQuiz($questionRepository->findAll(), 70, array(
     *      array($topic0, $percentage0),
     *      array($topic1, $percentage1),
     *      array($topic2, $percentage2),
     * ));
     * 
     * @param Question[] $questions to use
     * @param integer $quizSize number of questions to put in quiz
     * @param array $percentages of questions of each topics
     * 
     * @return Quiz
     * 
     * @throws QuizFactoryException if there is not enough questions in a topic
     */
    public function createCategorizedRandomQuiz(array $questions, $quizSize, array $percentages)
    {
        $this->checkPercentages($percentages);
        
        $quizBuilder = new QuizBuilder();
        $numberOfQuestions = $this->calculateNumberQuestionsPerTopics($quizSize, $percentages);
        $categorizedQuestions = $this->questionManager->sortQuestionsByTopics($questions);
        
        foreach ($percentages as $percentage) {
            $topic = $percentage[0];
            
            if (!isset($categorizedQuestions[$topic])) {
                throw new QuizFactoryException('No any questions in topic '.$topic->getEntitled());
            }
            
            $size = $numberOfQuestions[$topic];
            $candidates = $categorizedQuestions[$topic];
            
            try {
                $randomQuestions = $this->questionManager->getRandomQuestions($candidates, $size);
            } catch (ZCEPracticeTestException $ex) {
                throw new QuizFactoryException($ex->getMessage().' in topic '.$topic->getEntitled());
            }
            
            $quizBuilder->addQuestions($randomQuestions);
        }
        
        return $quizBuilder->shuffleQuestions()->getQuiz();
    }
    
    /**
     * Convert percentages per topics to a number of questions.
     * Fill with one of each topic if sum of rounded numbers is not enough.
     * 
     * @param integer $quizSize
     * @param array $percentages
     * 
     * @return Question[]
     */
    private function calculateNumberQuestionsPerTopics($quizSize, array $percentages)
    {
        $questionsNumber = new SplObjectStorage();
        $sum = $this->getPercentagesSum($percentages);
        $size = 0;
        
        foreach ($percentages as $percentage) {
            $topic = $percentage[0];
            $value = $percentage[1];
            
            $questionsNumber[$topic] = floor(($quizSize * $value) / $sum);
            
            $size += $questionsNumber[$topic];
        }
        
        $questionsNumber->rewind();

        while ($size < $quizSize) {
            $n = $questionsNumber[$questionsNumber->current()];
            $n++;
            $questionsNumber[$questionsNumber->current()] = $n;
            
            $questionsNumber->next();
            
            if (!$questionsNumber->valid()) {
                $questionsNumber->rewind();
            }

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
     * (array of [Topic, double])
     * 
     * @param array $percentages
     * 
     * @throws QuizFactoryException
     */
    private function checkPercentages(array $percentages)
    {
        foreach ($percentages as $percentage) {
            if (!($percentage[0] instanceof Topic)) {
                throw new QuizFactoryException(sprintf(
                    'percentages must be an array of [topic, number]. Got instance of "%s" as topic',
                    get_class($percentage[0])
                ));
            }
            
            if (!is_numeric($percentage[1])) {
                throw new QuizFactoryException(sprintf(
                    'percentages must be an array of [topic, number]. Got "%s" as number',
                    $percentage[1]
                ));
            }
        }
    }
}
