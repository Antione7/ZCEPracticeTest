<?php

namespace ZCEPracticeTest\Core\Entity;

/**
 * QuizQuestion
 */
class QuizQuestion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Quiz
     */
    private $quiz;

    /**
     * @var Question
     */
    private $question;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quiz
     *
     * @param Quiz $quizze
     * 
     * @return QuizQuestion
     */
    public function setQuiz(Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return Quiz 
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set question
     *
     * @param Question $question
     * 
     * @return QuizQuestion
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return Question 
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
