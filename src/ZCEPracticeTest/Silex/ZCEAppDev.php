<?php

namespace ZCEPracticeTest\Silex;

use ZCEPracticeTest\Silex\ZCEApp;

class ZCEAppDev extends ZCEApp
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->enableDebug();
    }
}
