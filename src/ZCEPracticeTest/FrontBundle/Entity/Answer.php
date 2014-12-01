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
 * @ORM\Table(name="answer")
 * @ORM\Entity(repositoryClass="ZCEPracticeTest\FrontBundle\Repository\AnswerRepository")
 */
class Answer
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
     * Answer's Entitled
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
     * Answer's value
     * @var boolean
     *
     * @ORM\Column(name="isValid", type="boolean")
     * @Assert\NotBlank()
     */
    private $isValid;

    /**
     * @var ZcePracticeTest\Entity\Question
     * @ORM\OneToMany(targetEntity="Question", mappedBy="answers")
     * @ORM\JoinColumn(name="answer_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @param string $entitled
     */
    public function setEntitled($entitled)
    {
        $this->entitled = $entitled;
    }

    /**
     * @return string
     */
    public function getEntitled()
    {
        return $this->entitled;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param boolean $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }

    /**
     * @return boolean
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Return to json format the answer entity
     * @return array
     */
    public function jsonSerialize ()
    {
        return array(
            'id' => $this->id,
            'entitled' => $this->entitled,
            'isValid' => $this->isValid
        );
    }

}