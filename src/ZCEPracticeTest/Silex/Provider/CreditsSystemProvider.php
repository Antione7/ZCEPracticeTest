<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Credits\Service\CreditsInitializer;
use ZCEPracticeTest\Credits\Service\CreditsManager;
use ZCEPracticeTest\Credits\Listener\UserListener;
use ZCEPracticeTest\Credits\Listener\CreditUseListener;

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
        
        $app['zce.credits.initializer'] = $app->share(function () use ($app) {
            $freeCreditsInit = $app['parameters']['credits']['free_credits_init'] ?: 0;
            
            return new CreditsInitializer($freeCreditsInit);
        });
    }
    
    public function boot(Application $app)
    {
        $app['dispatcher']->addSubscriber(new CreditUseListener(
            $app['zce.credits.manager'],
            $app['orm.em']
        ));
        
        $app['dispatcher']->addSubscriber(new UserListener(
            $app['zce.credits.initializer'],
            $app['orm.em']
        ));
    }
}
