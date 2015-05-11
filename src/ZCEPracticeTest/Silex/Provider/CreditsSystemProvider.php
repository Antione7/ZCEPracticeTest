<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use ZCEPracticeTest\Credits\Exception\CreditsSystemException;
use ZCEPracticeTest\Credits\Service\CreditsInitializer;
use ZCEPracticeTest\Credits\Service\CreditsManager;
use ZCEPracticeTest\Credits\Listener\UserListener;
use ZCEPracticeTest\Credits\Listener\CreditUseListener;
use ZCEPracticeTest\Credits\Listener\FirstQuizCreationListener;

class CreditsSystemProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        self::checkParameters($app);
        
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
        
        $app['dispatcher']->addSubscriber(new FirstQuizCreationListener(
            $app['zce.credits.manager'],
            $app['orm.em']->getRepository('ZCE:Quiz'),
            $app['parameters']['credits']['first_quiz_name']
        ));
    }
    
    /**
     * @param Application $app
     * 
     * @throws CreditsSystemException if not free quiz name is defined
     */
    private static function checkParameters(Application $app)
    {
        if (
            !isset($app['parameters']['credits']['first_quiz_name'])
            || (0 === strlen($app['parameters']['credits']['first_quiz_name']))
        ) {
            throw new CreditsSystemException(
                'Credits system cannot work if no free quiz name is defined. Check your parameters'
            );
        }
    }
}
