<?php

namespace ZCEPracticeTest\Silex;

use ZCEPracticeTest\Silex\ZCEApp;

class ZCEAppDev extends ZCEApp
{
    /**
     * Constructor
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = array())
    {
        $values['debug'] = true;
        
        parent::__construct($values);
    }
}
