<?php

namespace ZCEPracticeTest\Silex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Logging\DebugStack;

class ZCEAppDev extends ZCEApp
{
    /**
     * @var boolean
     */
    const DEBUG_QUERIES = false;
    
    /**
     * Constructor
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = array())
    {
        $values['debug'] = true;
        
        parent::__construct($values);
        
        $this->logDoctrine();
    }
    
    private function logDoctrine()
    {
        $logger = new DebugStack();
        $this['db.config']->setSQLLogger($logger);
        
        $this->after(function(Request $request, Response $response) use ($logger) {
            $response->headers->set('debug-doctrine-queries', count($logger->queries));
            
            if (self::DEBUG_QUERIES) {
                foreach ($logger->queries as $query) {
                    var_dump($query['sql']);
                }
            }
        });
    }
}
