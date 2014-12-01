<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\FrontBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question entity
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="ZCEPracticeTest\FrontBundle\Repository\QuestionRepository")
 */
class Question
{

    /**
     * Id of question entity
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Entitled of question
     * @var string
     *
     * @ORM\Column(name="entitled", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $entitled;

    /**
     * Code of question, not required
     * @var string
     *
     * @ORM\Column(name="code", type="text")
     *
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $code;

    /**
     * Array of answers
     * @var array
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $answers;

    /**
     * @param array $answers
     */
    public function setAnswers ($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return array
     */
    public function getAnswers ()
    {
        return $this->answers;
    }

    /**
     * add answer in collection
     * @param ZCEPracticeTest\Entity\Answer $answer
     */
    public function addAnswer ($answer)
    {
        $this->answers[] = $answer;
    }

    /**
     * @param string $code
     */
    public function setCode ($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode ()
    {
        return $this->code;
    }

    /**
     * @param string $entitled
     */
    public function setEntitled ($entitled)
    {
        $this->entitled = $entitled;
    }

    /**
     * @return string
     */
    public function getEntitled ()
    {
        return $this->entitled;
    }

    /**
     * @param int $id
     */
    public function setId ($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }


}