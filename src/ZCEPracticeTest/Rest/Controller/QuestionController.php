<?php

/**
 * PHP version 5.5
 *
 * @category Controller
 * @package  Rest
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Rest\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityRepository;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  Rest
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class QuestionController
{
    /**
     * @var EntityRepository
     */
    private $questionRepository;
    
    /**
     * @param EntityRepository $questionRepository
     */
    public function __construct(EntityRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }
    
    /**
     * @return JsonResponse
     */
    public function questionAction ()
    {
        $questions = $this->questionRepository->getAll();
        
        return new JsonResponse((object) $questions);
    }
}
