<?php

namespace ZCEPracticeTest\Silex;

use Silex\Application as SilexApplication;
use Silex\Provider\ServiceControllerServiceProvider;
use ZCEPracticeTest\Core\Controller\GetController;

class ZCEApp extends SilexApplication
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->register(new ServiceControllerServiceProvider());
        
        $this->registerServices();
        $this->registerRoutes();
    }
    
    /**
     * Register services
     */
    protected function registerServices()
    {
        $this['get.controller'] = $this->share(function () {
            return new GetController($this['dispatcher']);
        });
    }
    
    /**
     * Register routes
     */
    protected function registerRoutes()
    {
        $this
            ->get('/GET/questions', 'get.controller:questionAction')
            ->bind('front-get-questions')
        ;
    }
    
    /**
     * Enable app debug
     */
    protected function enableDebug()
    {
        $this['debug'] = true;
    }
}
