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
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class SessionController
{
    /**
     * @var EntityRepository
     */
    private $sessionRepository;
    
    /**
     * @param EntityRepository $sessionRepository
     */
    public function __construct(EntityRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }
    
    /**
     * @return JsonResponse
     */
    public function createAction()
    {
        $data = null;
        
        return new JsonResponse((object) $data);
    }
}
