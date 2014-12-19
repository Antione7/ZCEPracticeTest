<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Rest\Controller\QuestionController;
use ZCEPracticeTest\Rest\Controller\SessionController;

class RestAPIProvider implements ServiceProviderInterface, ControllerProviderInterface
{
    public function register(Application $app)
    {
        $app['zce.rest.question.controller'] = $app->share(function () use ($app) {
            $questionRepository = $app['orm.em']->getRepository('ZCE:Question');
            
            return new QuestionController($questionRepository);
        });
        
        $app['zce.rest.session.controller'] = $app->share(function () use ($app) {
            $sessionRepository = $app['orm.em']->getRepository('ZCE:Session');
            
            return new SessionController($sessionRepository);
        });
    }
    
    public function boot(Application $app)
    {
    }
    
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers
            ->get('/questions', 'zce.rest.question.controller:questionAction')
        ;
        
        $controllers
            ->post('/session', 'zce.rest.session.controller:createAction')
        ;

        return $controllers;
    }
}
