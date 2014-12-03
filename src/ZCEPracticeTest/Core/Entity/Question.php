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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Question entity
 *
 * @category Entity
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 * @Table(name="question")
 * @Entity(repositoryClass="ZCEPracticeTest\Core\Repository\QuestionRepository")
 */
class Question
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
     * Entitled of question
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
     * Code of question, not required
     * @var string
     *
     * @Column(name="code", type="text")
     *
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $code;

    /**
     * Array of answers
     * @var array
     * @OneToMany(targetEntity="ZCEPracticeTest\Core\Entity\Answer", mappedBy="question", cascade={"persist", "remove"})
     * @JoinColumn(onDelete="CASCADE")
     */
    private $answers;

    /**
     * @var ZCEPracticeTest\Core\Category
     * @ManyToOne(targetEntity="Category")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    public function __construct ()
    {
        $this->answers= new ArrayCollection();
    }

    /**
     * @param array $answers
     */
    public function setAnswers ($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
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
        $this->answers->add($answer);
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

    /**
     * @param \ZCEPracticeTest\Core\Entity\ZCEPracticeTest\Core\Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \ZCEPracticeTest\Core\Entity\ZCEPracticeTest\Core\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Return to json format the question entity
     * @return array
     */
    public function jsonSerialize ()
    {
        $answers = array();
        foreach ($this->answers as $answer) {
            $answers[] = $answer->jsonSerialize();
        }

        return array(
            'id' => $this->id,
            'entitled' => $this->entitled,
            'code' => $this->code,
            'answers' => $answers
        );
    }
}
