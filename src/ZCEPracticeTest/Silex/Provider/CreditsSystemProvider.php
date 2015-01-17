<?php

namespace ZCEPracticeTest\Silex\Provider;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use ZCEPracticeTest\Credits\Service\CreditsManager;
use ZCEPracticeTest\Credits\Listener\CreditUseListener;
use Silex\ServiceProviderInterface;
use Silex\Application;

class CreditsSystemProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['zce.credits.manager'] = $app->share(function () use ($app) {
            return new CreditsManager(
                $app['orm.em']->getRepository('ZCECredits:Credits'),
                $app['security']
            );
        });
    }
    
    public function boot(Application $app)
    {
        $app['dispatcher']->addSubscriber(new CreditUseListener(
            $app['zce.credits.manager'],
            $app['orm.em']
        ));
    }
}
