<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Rest\Controller\QuestionController;

class RestAPIProvider implements ServiceProviderInterface, ControllerProviderInterface
{
    public function register(Application $app)
    {
        $app['question.controller'] = $app->share(function () use ($app) {
            $questionRepository = $app['orm.em']->getRepository('ZCE:Question');
            
            return new QuestionController($questionRepository);
        });
    }
    
    public function boot(Application $app)
    {
    }
    
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers
            ->get('/questions', 'question.controller:questionAction')
        ;

        return $controllers;
    }
}
