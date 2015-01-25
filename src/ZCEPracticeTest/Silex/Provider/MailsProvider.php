<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Mails\Service\MailFactory;
use ZCEPracticeTest\Mails\Listener\EventsListener;

class MailsProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['zce.mails.factory'] = $app->share(function () use ($app) {
            return new MailFactory(
                $app['twig'],
                $app['parameters']['swiftmailer']['mailParameters']
            );
        });
    }
    
    public function boot(Application $app)
    {
        $app['dispatcher']->addSubscriber(new EventsListener(
            $app['zce.mails.factory'],
            $app['mailer'],
            $app['zce.credits.manager'],
            $app['locale']
        ));
        
        // Add twig template path.
        if (isset($app['twig.loader.filesystem'])) {
            $app['twig.loader.filesystem']->addPath($app['project.root'] . '/src/ZCEPracticeTest/Mails/Template/', 'mails');
        }
    }
}
