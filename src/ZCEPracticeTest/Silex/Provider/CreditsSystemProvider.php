<?php

namespace ZCEPracticeTest\Silex\Provider;

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
                $app['security']->getToken()
            );
        });
        
        $app['zce.credits.listeners.use_credit'] = $app->share(function () use ($app) {
            new CreditUseListener(
                $app['zce.credits.manager'],
                $app['orm.em']
            );
        });
    }
    
    public function boot(Application $app)
    {
        $creditsManager = $app['zce.credits.manager'];
        $om = $app['orm.em'];
        
        $app['dispatcher']->addSubscriber(new CreditUseListener($creditsManager, $om));
    }
}
