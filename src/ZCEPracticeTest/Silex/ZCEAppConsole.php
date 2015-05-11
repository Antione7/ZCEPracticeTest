<?php

namespace ZCEPracticeTest\Silex;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Silex\Application as SilexApplication;
use ZCEPracticeTest\Core\Command\LoadFixturesCommand;
use ZCEPracticeTest\Core\Command\CreateZCPEQuizCommand;
use ZCEPracticeTest\Core\Command\CloseSessionsTimeoutCommand;
use ZCEPracticeTest\Silex\Provider\ImportExportProvider;
use ZCEPracticeTest\ImportExport\Command\ImportQuestionCommand;

class ZCEAppConsole extends Application
{
    /**
     * @var SilexApplication
     */
    private $silexApp;
    
    /**
     * Constructor
     * 
     * @param SilexApplication $app
     */
    public function __construct(SilexApplication $app)
    {
        parent::__construct('ZCE Practice Test', '1.0');
        
        $this->silexApp = $app;
        
        $app->register(new ImportExportProvider());

        $app->register(new \Silex\Provider\MonologServiceProvider(), array(
            'monolog.logfile' => __DIR__.'/ZCEPracticeTest.log',
        ));
        
        $app->get('/', function () {
            return '';
        });
        
        $app->boot();
        
        $this->registerCommands();
        
        $this->run();
    }
    
    public function registerCommands()
    {
        $em = $this->silexApp['orm.em'];
        
        $this->add(new LoadFixturesCommand($em));
        $this->add(new CreateZCPEQuizCommand($em, $this->silexApp['zce.core.zcpe_quiz_factory']));
        $this->add(new ImportQuestionCommand($em, $this->silexApp['zce.import_export.import_question']));
        $this->add(new CloseSessionsTimeoutCommand($em, $this->silexApp['monolog']));
        
        // Register Doctrine ORM commands
        $helperSet = new HelperSet(array(
            'db' => new ConnectionHelper($em->getConnection()),
            'em' => new EntityManagerHelper($em)
        ));

        $this->setHelperSet($helperSet);
        ConsoleRunner::addCommands($this);
    }
    
    public function getSilexApplication()
    {
        return $this->silexApp;
    }
}
