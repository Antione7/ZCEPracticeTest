<?php

use ZCEPracticeTest\Silex\Core\ZCEApp;
use ZCEPracticeTest\Silex\Rest\Provider\RestAPIProvider;

class App extends ZCEApp
{
    /**
     * Constructor
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        
        $this->registerRestAPI();
    }
    
    private function registerRestAPI()
    {
        $restAPIProvider = new RestAPIProvider();
        
        $this->register($restAPIProvider);
        $this->mount('/api', $restAPIProvider);
    }
}
