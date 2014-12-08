<?php

namespace ZCEPracticeTest\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 */
class Question
{
    /**
     * @var integer
     */
    private $id;

    /**
     * Entitled of question
     * 
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $entitled;

    /**
     * Code of question, not required
     * 
     * @var string
     *
     * @Assert\Length(
     *      max="4096"
     * )
     */
    private $code;

    /**
     * @var \ZCEPracticeTest\Core\Entity\Category
     */
    private $category;


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
     * Set entitled
     *
     * @param string $entitled
     * @return Question
     */
    public function setEntitled($entitled)
    {
        $this->entitled = $entitled;

        return $this;
    }

    /**
     * Get entitled
     *
     * @return string 
     */
    public function getEntitled()
    {
        return $this->entitled;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Question
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set category
     *
     * @param \ZCEPracticeTest\Core\Entity\Category $category
     * @return Question
     */
    public function setCategory(\ZCEPracticeTest\Core\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ZCEPracticeTest\Core\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Return to json format the question entity
     * 
     * @return array
     */
    public function jsonSerialize ()
    {
        return array(
            'id' => $this->id,
            'entitled' => $this->entitled,
            'code' => $this->code,
        );
    }
}
