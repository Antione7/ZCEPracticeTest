<?php

namespace ZCEPracticeTest\Silex\Provider;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Silex\ServiceProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Front\Controller\FrontController;
use ZCEPracticeTest\Front\Controller\PanelController;

class FrontProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['zce.front.front.controller'] = $app->share(function () use ($app) {
            return new FrontController($app['twig']);
        });
        
        $app['zce.front.panel.controller'] = $app->share(function () use ($app) {
            return new PanelController(
                $app['twig'],
                $app['security']->getToken(),
                $app['orm.em']->getRepository('ZCE:Session'),
                $app['url_generator']->generate('home')
            );
        });

        // Import Front translation into twig templates
        $app['translator'] = $app->share($app->extend('translator', function (Translator $translator, $app) {

            $translator->addLoader('yaml', new YamlFileLoader());
            
            $translator->locales = array();
            foreach (glob($app['project.root'] . '/src/ZCEPracticeTest/Front/Translation/trans.*.yml') as $localeFile) {
                $lang = pathinfo($localeFile, PATHINFO_FILENAME);
                $locale = substr($lang, strrpos($lang, '.') + 1);
                $translator->addResource('yaml', $localeFile, $locale);
                array_push($translator->locales, $locale);
            }
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
            $app['twig.loader.filesystem']->addPath($app['project.root'] . '/src/ZCEPracticeTest/Front/Views/Panel/', 'panel');
        }
    }
}
