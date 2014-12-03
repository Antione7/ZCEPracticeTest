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
namespace ZCEPracticeTest\Core\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question entity
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 * @Table(name="answer")
 * @Entity(repositoryClass="ZCEPracticeTest\Core\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * Id of question entity
     * @var integer
     *
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Answer's Entitled
     * @var string
     *
     * @Column(name="entitled", type="text")
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
     * @Column(name="isValid", type="boolean")
     * @Assert\NotBlank()
     */
    private $isValid;

    /**
     * @var ZcePracticeTest\Entity\Question
     * @ManyToOne(targetEntity="ZCEPracticeTest\Core\Entity\Question", inversedBy="answers")
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
