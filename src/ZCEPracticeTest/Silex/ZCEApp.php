<?php

namespace ZCEPracticeTest\Silex;

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use ZCEPracticeTest\Core\Service\QuestionParser;
use ZCEPracticeTest\Core\Event\QuestionEvent;
use ZCEPracticeTest\Core\Listener\QuestionListener;
use ZCEPracticeTest\Core\Controller\GetController;

class ZCEApp extends Application
{
    /**
     * Constructor
     *
     * @param array $values The parameters or objects.
     */
    public function __construct(array $values = array())
    {
        parent::__construct($values);
        
        $this->registerDoctrineDBAL();
        $this->registerDoctrineORM();
        $this->registerServices();
        $this->registerListeners();
        $this->registerControllers();
        $this->registerRoutes();
    }
    
    private function registerDoctrineDBAL()
    {
        $this->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'    => 'pdo_mysql',
                'host'      => 'localhost',
                'dbname'    => 'zce',
                'user'      => 'root',
                'password'  => 'root',
                'charset'   => 'utf8',
            ),
        ));
    }
    
    private function registerDoctrineORM()
    {
        $this->register(new DoctrineOrmServiceProvider(), array(
            'orm.proxies_dir' => $this['project.root'].'/var/cache/doctrine/proxies',
            'orm.em.options' => array(
                'mappings' => array(
                    array(
                        'type' => 'annotation',
                        'namespace' => 'ZCEPracticeTest\Core\Entity',
                        'path' => $this['project.root'].'/src/ZCEPracticeTest/Core/Entity',
                        'alias' => 'ZCE',
                    ),
                ),
            ),
        ));
    }
    
    private function registerServices()
    {
        $this['zce.question_parser'] = $this->share(function () {
            return new QuestionParser();
        });
        
        $this['zce.listener.question'] = $this->share(function () {
            return new QuestionListener($this['orm.em'], $this['zce.question_parser']);
        });
    }
    
    private function registerListeners()
    {
        $dispatcher = $this['dispatcher'];
        
        $dispatcher->addListener(QuestionEvent::QUESTION_INIT, array($this['zce.listener.question'], 'onQuestionsInit'));
    }
    
    /**
     * Register controllers as services as they are dependencies
     */
    private function registerControllers()
    {
        $this->register(new ServiceControllerServiceProvider());
        
        $this['get.controller'] = $this->share(function () {
            return new GetController($this['dispatcher']);
        });
    }
    
    /**
     * Register routes
     */
    private function registerRoutes()
    {
        $this
            ->get('/GET/questions', 'get.controller:questionAction')
            ->bind('front-get-questions')
        ;
    }
}
