<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Silex\ControllerProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Front\Controller\FrontController;
use ZCEPracticeTest\Front\Controller\SessionController;

class FrontProvider implements ServiceProviderInterface, ControllerProviderInterface
{
    public function register(Application $app)
    {
        $app['front.controller'] = $app->share(function () use ($app) {
            return new FrontController($app['twig']);
        });
        
        $app['session.controller'] = $app->share(function () use ($app) {
            $sessionRepository = $app['orm.em']->getRepository('ZCE:Session');
            
            return new SessionController($app['twig'], $app['security']->getToken(), $sessionRepository);
        });
    }
    
    public function boot(Application $app)
    {
        if (!isset($app['twig'])) {
            throw new \RuntimeException('Twig must be enabled to use Front');
        }
        
        // Add twig template path.
        if (isset($app['twig.loader.filesystem'])) {
            $app['twig.loader.filesystem']->addPath($app['project.root'] . '/src/ZCEPracticeTest/Front/Views/', 'views');
            $app['twig.loader.filesystem']->addPath($app['project.root'] . '/src/ZCEPracticeTest/Front/Views/Front/', 'front');
            $app['twig.loader.filesystem']->addPath($app['project.root'] . '/src/ZCEPracticeTest/Front/Views/Session/', 'session');
        }
    }
    
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers
            ->get('/', 'front.controller:indexAction')
            ->bind('front-index')
        ;
        
        $controllers
            ->get('/sessions', 'session.controller:indexAction')
            ->bind('session-index')
        ;

        return $controllers;
    }
}
