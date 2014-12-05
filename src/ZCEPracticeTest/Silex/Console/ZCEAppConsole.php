<?php

namespace ZCEPracticeTest\Silex\Console;

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
        
        $app->run();
        
        $this->registerCommands();
        
        $this->run();
    }
    
    public function registerCommands()
    {
        $this->add(new LoadFixturesCommand());
        
        // Register Doctrine ORM commands
        $helperSet = new HelperSet(array(
            'db' => new ConnectionHelper($this->silexApp['orm.em']->getConnection()),
            'em' => new EntityManagerHelper($this->silexApp['orm.em'])
        ));

        $this->setHelperSet($helperSet);
        ConsoleRunner::addCommands($this);
    }
    
    public function getSilexApplication()
    {
        return $this->silexApp;
    }
}
