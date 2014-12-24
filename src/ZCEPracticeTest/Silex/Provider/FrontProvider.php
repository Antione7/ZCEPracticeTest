<?php

namespace ZCEPracticeTest\Silex\Provider;

use Symfony\Component\Translation\Loader\YamlFileLoader;
use Silex\ServiceProviderInterface;
use Silex\ControllerProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Front\Controller\FrontController;
use ZCEPracticeTest\Front\Controller\SessionController;
use ZCEPracticeTest\Front\Controller\TemplateController;

class FrontProvider implements ServiceProviderInterface, ControllerProviderInterface
{
    public function register(Application $app)
    {
        $app['zce.front.front.controller'] = $app->share(function () use ($app) {
            return new FrontController($app['twig']);
        });
        
        $app['zce.front.session.controller'] = $app->share(function () use ($app) {
            return new SessionController(
                    $app['twig'],
                    $app['security']->getToken(),
                    $app['orm.em']->getRepository('ZCE:Session'),
                    $app['zce.core.zcpe_quiz_factory'],
                    $app['orm.em']
            );
        });
        
        $app['zce.front.template.controller'] = $app->share(function () use ($app) {
            return new TemplateController($app['twig']);
        });
        
        // Import Front translation into twig templates
        $app['translator'] = $app->share($app->extend('translator', function ($translator, $app) {
            $translator->addLoader('yaml', new YamlFileLoader());

            $translator->addResource('yaml', $app['project.root'] . '/src/ZCEPracticeTest/Front/Translation/trans.en.yml', 'en');
            $translator->addResource('yaml', $app['project.root'] . '/src/ZCEPracticeTest/Front/Translation/trans.fr.yml', 'fr');

            return $translator;
        }));
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
            $app['twig.loader.filesystem']->addPath($app['project.root'] . '/src/ZCEPracticeTest/Front/Views/Template/', 'template');
        }
    }
    
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        
        $controllers->value('locale', $app['locale']);
        
        $controllers
            ->get('/', 'zce.front.front.controller:indexAction')
            ->bind('front-index')
        ;
        
        $controllers
            ->get('/about', 'zce.front.front.controller:aboutAction')
            ->bind('front-about')
        ;
        
        $controllers
            ->get('/sessions', 'zce.front.session.controller:indexAction')
            ->bind('session-index')
        ;
        
        $controllers
            ->get('/sessions/quiz', 'zce.front.session.controller:quizAction')
            ->bind('session-quiz')
        ;
        
        $controllers
            ->get('/templates/Quizz.html', 'zce.front.template.controller:quizAction')
            ->bind('template-quiz')
        ;

        return $controllers;
    }
}
