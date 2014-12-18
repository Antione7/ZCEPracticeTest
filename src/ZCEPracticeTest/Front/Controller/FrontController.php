<?php

/**
 * PHP version 5.5
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
namespace ZCEPracticeTest\Front\Controller;

use Twig_Environment;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  Front
 * @author   Julien Maulny <jmaulny@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class FrontController
{
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function indexAction()
    {
        return $this->twig->render('@front/index.html.twig');
    }
}
