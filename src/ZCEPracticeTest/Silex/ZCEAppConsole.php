<?php

namespace ZCEPracticeTest\Silex;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Silex\Application as SilexApplication;
use ZCEPracticeTest\Core\Command\LoadFixturesCommand;

class ZCEAppConsole extends Application
{
    /**
     * @var SilexApplication
     */
    private $silexApp;
    
    /**
     * Constructor
     * 
     * @param array $values The parameters or objects.
     */
    public function __construct(SilexApplication $app)
    {
        parent::__construct('ZCE Practice Test', '1.0');
        
        $this->silexApp = $app;
        
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
