<?php

namespace ZCEPracticeTest\Silex\Provider;

use Silex\ServiceProviderInterface;
use Silex\Application;
use ZCEPracticeTest\ImportExport\Service\QuestionImport;

class ImportExportProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['zce.import_export.import_question'] = $app->share(function () use ($app) {
            $topicRepository = $app['orm.em']->getRepository('ZCE:Topic');
            
            return new QuestionImport($topicRepository);
        });
    }
    
    public function boot(Application $app)
    {
    }
}
