<?php

namespace ZCEPracticeTest\Silex\Console;

use Symfony\Component\Console\Application;
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
    }
    
    public function getSilexApplication()
    {
        return $this->silexApp;
    }
}
