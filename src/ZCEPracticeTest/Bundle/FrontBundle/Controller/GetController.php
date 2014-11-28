<?php

namespace ZCEPracticeTest\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GetController extends Controller
{
    public function questionAction ()
    {
        // event initialize questions
        return $this->render('ZCEPracticeTestFrontBundle:Default:index.html.twig', array());
    }
}
