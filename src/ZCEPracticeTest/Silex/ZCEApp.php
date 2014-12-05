<?php

namespace ZCEPracticeTest\Silex;

use Symfony\Component\Yaml\Yaml;
use Silex\Application;
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
        
        $this->loadParameters();
        $this->loadConfig();
        $this->registerProviders();
        $this->registerDoctrineORM();
        $this->registerServices();
        $this->registerListeners();
        $this->registerControllers();
        $this->registerRoutes();
        $this->registerSimpleUser();
    }
    
    private function loadParameters()
    {
        $parametersFile = $this['project.root'].'/app/config/parameters.yml';
        
        if (file_exists($parametersFile)) {
            $parameters = Yaml::parse($parametersFile);
        } elseif (file_exists($parametersFile.'.dist')) {
            $parameters = Yaml::parse($parametersFile.'.dist');
        } else {
            throw new \Exception('No '.$parametersFile.' file found');
        }
        
        $this['parameters'] = $parameters;
    }
    
    private function loadConfig()
    {
        $configFile = $this['project.root'].'/app/config/config.yml';
        
        if (file_exists($configFile)) {
            $config = Yaml::parse($configFile);
        } else {
            throw new \Exception('No '.$configFile.' file found');
        }
        
        $this['config'] = $config;
        
        $this['security.firewalls'] = $config['security']['firewalls'];
        $this['swiftmailer.options'] = $config['swiftmailer'];
    }
    
    private function registerProviders()
    {
        $this->register(new \Silex\Provider\DoctrineServiceProvider(), $this['parameters']['database']);
        $this->register(new \Silex\Provider\SecurityServiceProvider());
        $this->register(new \Silex\Provider\RememberMeServiceProvider());
        $this->register(new \Silex\Provider\SessionServiceProvider());
        $this->register(new \Silex\Provider\ServiceControllerServiceProvider());
        $this->register(new \Silex\Provider\UrlGeneratorServiceProvider());
        $this->register(new \Silex\Provider\TwigServiceProvider());
        $this->register(new \Silex\Provider\SwiftmailerServiceProvider());
    }
    
    private function registerDoctrineORM()
    {
        $this->register(new DoctrineOrmServiceProvider(), array(
            'orm.proxies_dir' => $this['project.root'].'/var/cache/doctrine/proxies',
            'orm.em.options' => array(
                'mappings' => array(
                    
                    /**
                     * Core mappings
                     */
                    array(
                        'type' => 'yml',
                        'namespace' => 'ZCEPracticeTest\Core\Entity',
                        'path' => $this['project.root'].'/src/ZCEPracticeTest/Core/Resources/config/doctrine',
                        'alias' => 'ZCE',
                    ),
                    
                    /**
                     * SimpleUser mapping (register superclass SimpleUser\User)
                     */
                    array(
                        'type' => 'yml',
                        'namespace' => 'SimpleUser',
                        'path' => $this['project.root'].'/src/ZCEPracticeTest/Core/Resources/config/doctrine',
                    ),
                ),
            ),
        ));
    }
    
    /**
     * Register simple user library
     * Add user management and routes.
     */
    private function registerSimpleUser()
    {
        $simpleUserProvider = new \SimpleUser\UserServiceProvider();
        
        $this->register($simpleUserProvider);
        
        $this['user.options'] = $this['config']['simple.user'];
        
        $security = $this['security.firewalls'];
        $security['secured_area']['users'] = $this->share(function ($app) {
            return $app['user.manager'];
        });
        $this['security.firewalls'] = $security;
        
        $this->mount('/user', $simpleUserProvider);
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
            ->get('/', function () {
                return 'home';
            })
            ->bind('front-home')
        ;
        
        $this
            ->get('/GET/questions', 'get.controller:questionAction')
            ->bind('front-get-questions')
        ;
    }
}
