<?php

/**
 *
 *
 * PHP version 5.5
 *
 * @category Controller
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 *
 */
namespace ZCEPracticeTest\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ZCEPracticeTest\FrontBundle\Event\QuestionEvent;

/**
 * Get Controller.
 *
 * @category Controller
 * @package  FrontBundle
 * @author   Maxence Perrin <mperrin@darkmira.fr>
 * @license  Darkmira <darkmira@darkmira.fr>
 * @link     www.darkmira.fr
 */
class GetController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionAction ()
    {
        // event initialize questions
        $questionEvent = new QuestionEvent();
        $this->get('event_dispatcher')->dispatch(QuestionEvent::QUESTION_INIT, $questionEvent);

        return $this->render('ZCEPracticeTestFrontBundle:Default:index.html.twig', array(
            'questions' => $questionEvent->getQuestions()
        ));
    }
}
